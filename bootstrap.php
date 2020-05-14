<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
use Xpto\Application;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * @const string DS
 */
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * @const string APPLICATION_ENV
*/
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
 * Auto loader
 *
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require 'vendor' . DS . 'autoload.php';
$loader->register();

// Fix to read JMS annotations
AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation', __DIR__ . '/vendor/jms/serializer/src'
);

/**
 * Silex Application
 *
 * @var \Xpto\Application $app
 */
$app = new Application();
$app->setConfigFile([
    'config' . DS . 'config.yml',
    'config' . DS . 'orm.yml',
    'config' . DS . 'global.yml',
]);
$app->loadServices();
$app->loadDoctrineLogger();
$app->loadControllers();
$app->loadListeners();

$app['debug'] = APPLICATION_ENV == 'development' ? true : false;

return $app;
