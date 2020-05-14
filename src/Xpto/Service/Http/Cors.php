<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Http;

use Domain\Service\Http\Cors as CorsServiceInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
class Cors implements CorsServiceInterface
{
    /**
     * @var string
     */
    const HTTP_CORS = 'http.cors';

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $service = $this;

        /**
         * Add the HMAC validation service
         */
        $app[self::HTTP_CORS] = $app->protect(
            function (Request $request, Response $response) use ($service, $app) {
                return $service->handle($app, $request, $response);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {
        $app->flush();

        /* @var $routes \Symfony\Component\Routing\RouteCollection */
        $routes = $app['routes'];

        /* @var $route \Silex\Route */
        foreach ($routes->getIterator() as $id => $route) {
            $path = $route->getPath();

            $headers = implode(',', [
                'Authorization',
                'Accept',
                'X-Request-With',
                'Content-Type',
                'X-Session-Token',
                'X-Hmac-Hash',
                'X-Time',
                'X-Url'
            ]);

            /* @var $controller \Silex\Controller */
            $controller = $app->match(
                $path,
                function () use ($headers) {
                    return new Response(
                        null,
                        204,
                        [
                            "Allow" => "GET,POST,PUT,DELETE",
                            "Access-Control-Max-Age" => 84600,
                            "Access-Control-Allow-Origin" => "*",
                            "Access-Control-Allow-Credentials" => "false",
                            "Access-Control-Allow-Methods" => "GET,POST,PUT,DELETE",
                            "Access-Control-Allow-Headers" => $headers
                        ]
                    );
                }
            );

            $controller->method('OPTIONS');

            /* @var $controllerRoute \Silex\Route */
            $controllerRoute = $controller->getRoute();
            $controllerRoute->setCondition($route->getCondition());
            $controllerRoute->setSchemes($route->getSchemes());
            $controllerRoute->setMethods('OPTIONS');
        }
    }

    /**
     * (non-PHPdoc)
     * @see \Domain\Service\Cors\Cors::handle()
     */
    public function handle(Application $app, Request $request, Response $response)
    {
        $response->headers->set("Access-Control-Max-Age", "86400");
        $response->headers->set("Access-Control-Allow-Origin", "*");
    }
}
