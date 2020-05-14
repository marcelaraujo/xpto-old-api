<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto;

use Common\Iterator\Filter\File as FileFilterIterator;
use Common\Doctrine\EchoSQLLogger;
use DerAlex\Silex\YamlConfigServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Dflydev\Silex\Provider\Psr0ResourceLocator\Composer\ComposerResourceLocatorServiceProvider;
use Dflydev\Silex\Provider\Psr0ResourceLocator\Psr0ResourceLocatorServiceProvider;
use Xpto\Service\Log\MonologServiceProvider;
use Xpto\Service\Auth\Login as LoginServiceProvider;
use Xpto\View\Json as View;
use Knp\Provider\ConsoleServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Silex\Application as SilexApplication;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Application Module Bootstrap
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Application extends SilexApplication
{
    /**
     * Header authorization index
     *
     * @const string
     */
    const TOKEN_HEADER_KEY = 'Authorization';

    /**
     * Header request key index
     *
     * @const string
     */
    const TOKEN_REQUEST_KEY = '_token';

    /**
     * Construtor
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->before(
            function (Request $request) {
                // Skipping OPTIONS requests
                if ($request->getMethod() === 'OPTIONS') {
                    return;
                }

                // If body request is JSON, decode it!
                if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                    $data = json_decode($request->getContent(), true);
                    $request->request->replace(is_array($data) ? $data : []);
                }

                // Authorized routes
                $app = $this;
                $token = '';

                if (!$this->isPublicPath($request->getPathInfo(), $request->getMethod())) {
                    $token = $this->getTokenFromRequest($request);

                    if (!$this->isValidTokenForApplication($app, $token)) {
                        throw new AccessDeniedHttpException('Access Denied');
                    }

                    /* @var $profile \Xpto\Entity\Users\Profile */
                    $profile = $this->loadValidUser($app, $token);
                }

                // Validate request signature
                //if (!$this['hmac.validate.request']($request, $token)) {
                //    throw new AccessDeniedHttpException('Access Denied');
                //}
            }
        );

        // CORS
        $this->after(
            function (Request $request, Response $response, Application $app) {
                $app['http.cors']($request, $response);
            }
        );

        // Serialize exception messages
        $this->error(
            function (\Exception $e, $code = Response::HTTP_INTERNAL_SERVER_ERROR) {
                if ($e->getCode() !== 0) {
                    $code = $e->getCode();
                }

                if ($code > 505 || $code < 100) {
                    $code = 500;
                }

                return new View($e->getMessage(), $code);
            }
        );
    }

    /**
     * Load config file
     *
     * @param mixed $file
     * @return bool
     */
    public function setConfigFile($file = null)
    {
        if (is_array($file)) {
            foreach ($file as $config) {
                $this->register(new YamlConfigServiceProvider($config));
            }
            return true;
        }
        $this->register(new YamlConfigServiceProvider($file));
        return true;
    }

    /**
     * Load application services
     *
     * @return void
     */
    public function loadServices()
    {
        $this->register(new Psr0ResourceLocatorServiceProvider());

        $this->register(new ComposerResourceLocatorServiceProvider());

        $this->register(new MonologServiceProvider($this['config']['log']));

        $this->register(
            new DoctrineServiceProvider(),
            [
                "db.options" => $this['config']['database']
            ]
        );

        $this->register(
            new DoctrineOrmServiceProvider(),
            [
                "orm.proxies_dir" => sys_get_temp_dir(),
                'orm.proxies_namespace' => 'XptoDomainEntityProxy',
                'orm.auto_generate_proxies' => true,
                "orm.em.options" => [
                    "mappings" => $this['config']['mappings'],
                    "query_cache" => [
                        "driver" => "array"
                    ],
                    "metadata_cache" => [
                        "driver" => "array"
                    ],
                    "hydratation_cache" => [
                        "driver" => "array"
                    ]
                ]
            ]
        );

        $this->register(
            new SwiftmailerServiceProvider(),
            [
                'swiftmailer.options' => $this['config']['email']['config']
            ]
        );

        $this->register(
            new ConsoleServiceProvider(),
            [
                'console.name' => $this['config']['application']['name'],
                'console.version' => $this['config']['application']['version'],
                'console.project_directory' => $this['config']['application']['path']
            ]
        );

        $this->register(new TwigServiceProvider(), $this['config']['twig']);

        $path = __DIR__ . DS . 'Service';
        $extensions = ["php"];

        $recursiveDirectory = new RecursiveDirectoryIterator($path);
        $recursiveIterator = new RecursiveIteratorIterator($recursiveDirectory);
        $filtered = new FileFilterIterator($recursiveIterator, $extensions);

        /* @var $fileInfo \SplFileInfo */
        foreach ($filtered as $fileInfo) {
            $class = __NAMESPACE__ . str_replace(
                [__DIR__, DS],
                ['', '\\'],
                $fileInfo->getPathname()
            );

            $class = str_replace('.php', '', $class);

            $this->register(new $class);
        }
    }

    /**
     * Load logger to Doctrine Queries
     *
     * @return void
     */
    public function loadDoctrineLogger()
    {
        /* @var $config \Doctrine\DBAL\Configuration */
        $config = $this['db.config'];
        $config->setSQLLogger(new EchoSQLLogger($this['monolog.doctrine']));
    }

    /**
     * Load controllers
     *
     * @return void
     */
    public function loadControllers()
    {
        $this['routes'] = $this->extend(
            'routes',
            function (RouteCollection $routes, Application $app) {
                $loader = new YamlFileLoader(new FileLocator(__DIR__ . '/../../config'));
                $collection = $loader->load('routes.yml');

                $routes->addCollection($collection);

                return $routes;
            }
        );
    }

    /**
     * Load listeners
     *
     * @return void
     */
    public function loadListeners()
    {
        $path = __DIR__ . DS . 'Event';
        $extensions = ["php"];

        $recursiveDirectory = new RecursiveDirectoryIterator($path);
        $recursiveIterator = new RecursiveIteratorIterator($recursiveDirectory);
        $filtered = new FileFilterIterator($recursiveIterator, $extensions);

        /* @var $fileInfo \SplFileInfo */
        foreach ($filtered as $fileInfo) {
            $class = __NAMESPACE__ . str_replace(
                [__DIR__, DS],
                ['', '\\'],
                $fileInfo->getPathname()
            );

            $class = str_replace('.php', '', $class);

            $this['dispatcher']->addListener($class::NAME, [new $class($this), 'dispatch']);
        }
    }

    /**
     *
     * @param Request $request
     * @return Ambigous <string, multitype:, NULL, mixed, multitype:mixed >
     */
    private function getTokenFromRequest(Request $request)
    {
        return $request->headers->get(self::TOKEN_HEADER_KEY, $request->get(self::TOKEN_REQUEST_KEY));
    }

    /**
     * Check if path is a public route considering the HTTP verb.
     *
     * @param  string $path Uri path
     * @param  string $method HTTP Verb
     * @return boolean
     */
    private function isPublicPath($path, $method = 'GET')
    {
        $paths = [
            'POST' => [
                '/login/',
                '/signup/',
            ],
            'GET' => [
                '/',
            ],
            'PUT' => [
                // :)
            ],
            'DELETE' => [
                // :)
            ],
        ];

        $allow = [
            'OPTIONS'
        ];

        return in_array($method, $allow) || (array_key_exists($method, $paths) && in_array($path, $paths[$method]));
    }

    /**
     *
     * @param Application $app
     * @param string $token
     */
    private function isValidTokenForApplication(Application $app, $token)
    {
        return $app[LoginServiceProvider::AUTH_VALIDATE_TOKEN]($token);
    }

    /**
     *
     * @param Application $app
     * @param string $token
     * @return ProfileModel
     */
    private function loadValidUser(Application $app, $token)
    {
        return $app[LoginServiceProvider::AUTH_USER_GET]($token);
    }
}
