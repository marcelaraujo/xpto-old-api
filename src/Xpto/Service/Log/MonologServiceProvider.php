<?php

/*
 * This file is part of the Silex framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xpto\Service\Log;

use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Silex\Application;
use Silex\EventListener\LogListener;
use Silex\ServiceProviderInterface;

/**
 * Monolog Provider.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class MonologServiceProvider implements ServiceProviderInterface
{

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }

    public function register(Application $app)
    {
        $app['logger'] = (function () use ($app) {
            return $app['monolog.default'];
        });

        foreach ($this->config as $name => $config) {
            $app["monolog.{$name}"] = $app->share(
                function ($app) use ($config) {

                    $level = MonologServiceProvider::translateLevel($config['level']);
                    $bubble = isset($config['bubble']) ? boolval($config['bubble']) : true;

                    $log = new Logger($config['name']);
                    $log->pushHandler(new StreamHandler($config['logfile'], $level, $bubble, $config['permission']));

                    return $log;
                }
            );
        }

        $app['monolog.listener'] = $app->share(
            function () use ($app) {
                return new LogListener($app['logger']);
            }
        );
    }

    public function boot(Application $app)
    {
        if (isset($app['monolog.listener'])) {
            $app['dispatcher']->addSubscriber($app['monolog.listener']);
        }
    }

    public static function translateLevel($name)
    {
        // level is already translated to logger constant, return as-is
        if (is_int($name)) {
            return $name;
        }

        $levels = Logger::getLevels();
        $upper = strtoupper($name);

        if (!isset($levels[$upper])) {
            $message = "Provided logging level '{$name}' does not exist. Must be a valid monolog logging level.";

            throw new InvalidArgumentException($message);
        }

        return $levels[$upper];
    }
}
