<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/10 Time: 9:55
// +----------------------------------------------------------------------
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Events\Event;


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
    // 创建一个事件管理器
    $eventsManager = new EventsManager();

    // 处理异常和使用 NotFoundPlugin 未找到异常
    $eventsManager->attach(
        "dispatch:beforeException",
        function (Event $event, $dispatcher, Exception $exception) {
            // 代替控制器或者动作不存在时的路径
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(
                        [
                            'namespace' => 'MyApp\Controllers',
                            'controller' => 'error',
                            'action' => 'show404',
                        ]
                    );

                    return false;
            }
        }
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
foreach ($config->services as $service) {
    if (file_exists($config->application->servicesDir . $service)) {
        include $config->application->servicesDir . $service;
    }
}


