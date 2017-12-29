<?php
// +----------------------------------------------------------------------
// | Redis 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Xin\Redis as Client;

class Redis implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('redis', function () use ($config) {
            $host = $config->redis->host;
            $port = $config->redis->port;
            $auth = $config->redis->auth;
            $db = $config->redis->index;
            return Client::getInstance($host, $auth, $db, $port, 'service');
        });
    }
}
