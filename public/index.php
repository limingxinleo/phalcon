<?php

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('IS_CLI', false);

use Phalcon\Mvc\Application;

try {
    /** Read vendor autoload */
    if (file_exists(BASE_PATH . "/vendor/autoload.php")) {
        include BASE_PATH . "/vendor/autoload.php";
    }

    $di = require_once APP_PATH . '/bootstrap.php';
    /**
     * Handle the request
     */
    $application = new Application($di);
    $application->useImplicitView(false);

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    $error = $e->getMessage();
    echo $error;
    logger($error, 'error', 'error.log');
}
