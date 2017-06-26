<?php
// +----------------------------------------------------------------------
// | TestHelper [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
use Phalcon\Di;
use Phalcon\Loader;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT_PATH', realpath(__DIR__ . '/..'));
define('TESTS_PATH', ROOT_PATH . '/tests');
defined('APP_PATH') || define('APP_PATH', ROOT_PATH . '/app');
define('IS_CLI', false);

set_include_path(
    TESTS_PATH . PATH_SEPARATOR . get_include_path()
);

// Required for phalcon/incubator
include __DIR__ . '/../vendor/autoload.php';

// Use the application autoloader to autoload the classes
// Autoload the dependencies found in composer
$loader = new Loader();

$loader->registerDirs(
    [
        TESTS_PATH,
    ]
);

$loader->register();

// Add any needed services to the DI here
$di = require_once APP_PATH . '/bootstrap.php';

Di::setDefault($di);
