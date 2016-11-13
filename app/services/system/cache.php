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
        case 'file':
            $cache = new BackFile(
                $frontCache,
                [
                    "cacheDir" => $config->application->cacheDir . 'data/',
                ]
            );
            break;
        case 'memcached':
            $cache = new BackMemCached(
                $frontCache,
                [
                    "host" => env('MEMCACHED_HOST'),
                    "port" => env('MEMCACHED_PORT'),
                    "weight" => env('MEMCACHED_WEIGHT'),
                ]
            );
            break;
        case 'redis':
            $cache = new BackRedis(
                $frontCache,
                [
                    "host" => env('REDIS_HOST'),
                    "port" => env('REDIS_PORT'),
                    "auth" => env('REDIS_AUTH'),
                    'persistent' => env('REDIS_PERSISTENT'),
                    'index' => env('REDIS_INDEX'),
                    'prefix' => env('REDIS_PREFIX'),
                ]
            );
            dump($cache);
            break;
        default:
            exit('Sorry! The cache engine is not support!');
            break;
    }
    if ($cache !== null) {
        // 注入容器
        $di->set('cache', function () use ($cache) {
            return $cache;
        });
    }
}