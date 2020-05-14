<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 */
namespace Xpto\Tests;

/**
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
trait ApplicationControllerTestCase
{
    protected $authCreative = 'TOKEN 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a';
    protected $authCurator = 'TOKEN 894ad86f-6451-475d-8778-39af5b3906d9';
    protected $header = [
        'HTTP_Content-type' => 'application/json',
        'HTTP_Authorization' => 'TOKEN 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a',
    ];

    /**
     * App Boostrap
     *
     * @return \Silex\Application
     */
    public static function getBootstrap()
    {
        chdir(__DIR__ . '/../../../');

        $app = require 'bootstrap.php';

        return $app;
    }

    /**
     * Pré-teste
     *
     * @return \Silex\Application
     */
    public static function createApplication()
    {
        $app = self::getBootstrap();

        $app['debug'] = true;
        $app['session.test'] = false;
        $app['exception_handler']->disable();

        return $app;
    }
}
