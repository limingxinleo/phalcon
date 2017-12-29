<?php
// +----------------------------------------------------------------------
// | modelsMetadata 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model\Metadata\Files as MetadataFiles;
use Phalcon\Mvc\Model\MetaData\Redis as MetadataRedis;

class ModelsMetadata implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        /**
         * If the configuration specify the use of metadata adapter use it or use memory otherwise
         */
        $di->setShared('modelsMetadata', function () use ($config) {
            switch (strtolower($config->modelMeta->driver)) {
                case 'redis':
                    $modelsMetadata = new MetadataRedis([
                        'host' => $config->redis->host,
                        'port' => $config->redis->port,
                        'auth' => $config->redis->auth,
                        'persistent' => $config->redis->persistent,
                        'statsKey' => $config->modelMeta->statsKey,
                        'lifetime' => $config->modelMeta->lifetime,
                        'index' => $config->modelMeta->index,
                    ]);
                    break;
                case 'file':
                default:
                    $modelsMetadata = new MetadataFiles(
                        [
                            'metaDataDir' => $config->application->metaDataDir,
                        ]
                    );
                    break;
            }
            return $modelsMetadata;
        });
    }
}
