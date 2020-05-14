#!/usr/bin/env php
<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license proprietary
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
set_time_limit(0);

$app = require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'bootstrap.php';

use Xpto\Jobs\Token;

$console = $app['console'];
$console->add(new Token());
$console->run();