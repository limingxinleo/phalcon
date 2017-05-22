<?php
// +----------------------------------------------------------------------
// | redis 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
use limx\phalcon\Redis;

$di->setShared('redis', function () use ($config) {
    $host = $config->redis->host;
    $port = $config->redis->port;
    $auth = $config->redis->auth;
    $db = $config->redis->index;
    return Redis::getInstance($host, $auth, $db, $port);
});