<?php
// +----------------------------------------------------------------------
// | Web 服务文件 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;

use MyApp\Listeners\System\DispatchListener;


$di->setShared('router', function () {
    return require __DIR__ . '/routes.php';
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(
        [
            '.volt' => function ($view, $di) use ($config) {
                $volt = new VoltEngine($view, $di);

                $volt->setOptions(
                    [
                        'compiledPath' => $config->application->cacheDir . 'view/',
                        'compiledSeparator' => '_'
                    ]
                );

                return $volt;
            },
            // Generate Template files uses PHP itself as the template engine
            '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
        ]
    );

    return $view;
});

$di->set('dispatcher', function () {
    // 监听调度 dispatcher
    $eventsManager = new EventsManager();
    $dispatchListener = new DispatchListener();
    $eventsManager->attach(
        'dispatch',
        $dispatchListener
    );

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('MyApp\Controllers');
    // 分配事件管理器到分发器
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

/**
 * Read other services
 */
foreach ($config->services->mvc as $service) {
    if (file_exists($config->application->servicesDir . $service)) {
        include $config->application->servicesDir . $service;
    }
}


