<?php
// +----------------------------------------------------------------------
// | Cli 服务文件 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
use Phalcon\Cli\Dispatcher;

/**
 * Set the default namespace for dispatcher
 */
$di->setShared('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('MyApp\\Tasks');
    return $dispatcher;
});

$di->setShared("console", $console);

/**
 * Read other services
 */
foreach ($config->services->cli as $service) {
    if (file_exists($config->application->servicesDir . $service)) {
        include $config->application->servicesDir . $service;
    }
}

