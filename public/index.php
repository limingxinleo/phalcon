<?php

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Application;

try {

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    /**
     * Read the configuration
     */
    $config = include APP_PATH . "/config/config.php";

    /**
     * Read auto-loader
     */
    include APP_PATH . "/config/loader.php";

    /**
     * Read services
     */
    include APP_PATH . "/config/services.php";
    include APP_PATH . "/config/services_web.php";

    /**
     * Read vendor autoload
     */
    if (file_exists(BASE_PATH . "/vendor/autoload.php")) {
        include BASE_PATH . "/vendor/autoload.php";
    }

    /**
     * Read other services
     */
    foreach (glob(APP_PATH . '/services/*_service.php') as $v) {
        include $v;
    }

    /**
     * Handle the request
     */
    $application = new Application($di);
    $application->useImplicitView(false);

    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage();
}
