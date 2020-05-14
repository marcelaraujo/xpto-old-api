<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Auth;

use Domain\Entity\Users\User as UserModel;
use Domain\Service\Auth\Hmac as HmacServiceInterface;
use Mardy\Hmac\Adapters\HashHmac;
use Mardy\Hmac\Manager;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 * @author Marcel Araujo <admin@marcelaraujo.me>
 */
class Hmac implements HmacServiceInterface
{
    /**
     * @var string
     */
    const HMAC_VALIDATE_REQUEST = 'hmac.validate.request';

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     * @param Application $app
     */
    public function register(Application $app)
    {
        $service = $this;

        /**
         * Add the HMAC validation service
         */
        $app[self::HMAC_VALIDATE_REQUEST] = $app->protect(
            function (Request $request, $token = null) use ($app, $service) {
                return $service->validate($app, $request, $token);
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }

    /**
     * @see HmacServiceInterface::validate()
     * @param Application $application
     * @param Request $request
     * @param string $token
     * @return bool
     */
    public function validate(Application $application, Request $request, $token = '')
    {
        $method = $request->getMethod();
        $content = $request->getContent();

        /* @var $user UserModel */
        $user = $application->offsetExists('user') ? $application['user'] : null;

        /**
         * Getting variables
         */
        $time = filter_var($request->headers->get('x-time'), FILTER_SANITIZE_NUMBER_INT);
        $url  = filter_var($request->headers->get('x-url'), FILTER_SANITIZE_URL);
        $hmac = filter_var($request->headers->get('x-hmac-hash'), FILTER_SANITIZE_STRING);

        /**
         * For GET requests, this takes the form:
         * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}
         *
         * For POST requests, this would be:
         * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}{{RAW_POST_DATA}}
         *
         * And for PUT requests, this would be:
         * {{REQUEST_METHOD}}{{HTTP_HOST}}{{REQUEST_URI}}{{RAW_PUT_DATA}}
         */
        $data = "{$method}:{$url}" . (!empty($content) ? ":{$content}" : '');

        /**
         * If $user is null, this request is for login probably
         */
        if (!isset($token) || empty($token)) {
            $key  = hash('sha512', "{$data}:{$time}");
        } else {
            /**
             * Getting user email
             */
            $email = $user->getEmail();

            /**
             * Extract token
             */
            $arr = explode(' ', $token);
            $token = array_pop($arr);

            $key = hash('sha512', "{$email}:{$token}");
        }

        $manager = new Manager(new HashHmac());
        $manager->config([
            'algorithm' => 'sha512',
            'num-first-iterations' => 10,
            'num-second-iterations' => 10,
            'num-final-iterations' => 100,
        ]);

        //time to live, when checking if the hmac isValid this will ensure
        //that the time with have to be with this number of seconds
        $manager->ttl(2);

        //the current timestamp, this will be compared in the other API to ensure
        $manager->time($time);

        //the secure private key that will be stored locally and not sent in the http headers
        $manager->key($key);

        //the data to be encoded with the hmac, you could use the URI for this
        $manager->data($data);

        //to check if the hmac is valid you need to run the isValid() method
        //this needs to be executed after the encode method has been ran
        return $manager->isValid($hmac);
    }
}
