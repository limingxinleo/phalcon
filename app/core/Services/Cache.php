<?php
// +----------------------------------------------------------------------
// | Cache 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;
use Phalcon\Cache\Backend\Redis as BackRedis;
use Phalcon\Cache\Backend\Mongo as BackMongo;

class Cache implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
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
                            'host' => $config->redis->host,
                            'port' => $config->redis->port,
                            'auth' => $config->redis->auth,
                            'persistent' => $config->redis->persistent,
                            'index' => $config->redis->index,
                            'prefix' => ':cache:',
                            'statsKey' => '_PHCM',
                        ]
                    );
                    break;

                case 'mongo':
                    $server = sprintf("mongodb://%s:%d", $config->mongo->host, $config->mongo->port);
                    $cache = new BackMongo(
                        $frontCache,
                        [
                            'server' => $server,
                            'db' => $config->mongo->db,
                            'collection' => $config->mongo->collection,
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
                $di->setShared('cache', function () use ($cache) {
                    return $cache;
                });
                $di->setShared('modelsCache', function () use ($cache) {
                    return $cache;
                });
            }
        }
    }
}
