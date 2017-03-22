<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/13 Time: 15:12
// +----------------------------------------------------------------------
use Phalcon\Cache\Frontend\Data as FrontData;

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;
use Phalcon\Cache\Backend\Redis as BackRedis;

if ($config->cache->type !== false) {
    $frontCache = new FrontData(
        [
            "lifetime" => $config->cache->lifetime,
        ]
    );
    $cache = null;
    switch (strtolower($config->cache->type)) {
        case 'memcached':
            $cache = new BackMemCached(
                $frontCache,
                [
                    "host" => env('MEMCACHED_HOST', '127.0.0.1'),
                    "port" => env('MEMCACHED_PORT', '11211'),
                    "weight" => env('MEMCACHED_WEIGHT', 1),
                    'statsKey' => '_PHCM',
                ]
            );
            break;
        case 'redis':
            $cache = new BackRedis(
                $frontCache,
                [
                    'host' => $redis->host,
                    'port' => $redis->port,
                    'auth' => $redis->auth,
                    'persistent' => $redis->persistent,
                    'index' => $redis->index,
                    'prefix' => ':cache:',
                    'statsKey' => '_PHCM',
                ]
            );
            break;
        case 'file':
        default:
            $cache = new BackFile(
                $frontCache,
                [
                    "cacheDir" => $config->application->cacheDir . 'data/',
                ]
            );
            break;
    }
    if ($cache !== null) {
        // 注入容器
        $di->set('cache', function () use ($cache) {
            return $cache;
        });
        $di->set('modelsCache', function () use ($cache) {
            return $cache;
        });
    }
}