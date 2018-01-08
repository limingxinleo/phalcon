<?php

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('IS_CLI', false);

use Phalcon\Mvc\Application;

$di = require_once APP_PATH . '/bootstrap.php';
/**
 * Handle the request
 */
$application = new Application($di);
$application->useImplicitView(false);

$application->handle()->send();
