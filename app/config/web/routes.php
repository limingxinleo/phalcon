<?php
/**
 * 路由文件
 * 必须精确到控制器 App\Controllers\IndexController除外
 */
$router = new Phalcon\Mvc\Router(false);

$router->add('/:controller/:action/:params', [
    'namespace' => 'App\Controllers',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
]);

$router->add('/:controller', [
    'namespace' => 'App\Controllers',
    'controller' => 1
]);

return $router;
