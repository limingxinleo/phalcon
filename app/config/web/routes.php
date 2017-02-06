<?php
/**
 * 路由文件
 * 必须精确到控制器 MyApp\Controllers\IndexController除外
 */
$router = new Phalcon\Mvc\Router(false);

$router->add('/:controller/:action/:params', [
    'namespace' => 'MyApp\Controllers',
    'controller' => 1,
    'action' => 2,
    'params' => 3,
]);

$router->add('/:controller', [
    'namespace' => 'MyApp\Controllers',
    'controller' => 1
]);

return $router;
