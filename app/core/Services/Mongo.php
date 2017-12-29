<?php
// +----------------------------------------------------------------------
// | Mongo 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Collection\Manager;
use Phalcon\Db\Adapter\MongoDB\Client;

class Mongo implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        if ($config->mongo->isUtils) {
            $di->setShared('mongoManager', function () use ($config) {
                $host = $config->mongo->host;
                $port = $config->mongo->port;
                $uri = "mongodb://{$host}:{$port}";
                $options = [
                    'connect' => $config->mongo->connect, // true表示Mongo构造函数中建立连接。
                    'timeout' => $config->mongo->timeout, // 配置建立连接超时时间，单位是ms
                    'username' => $config->mongo->username, // 覆盖$server字符串中的username段，如果username包含冒号:时，选用此种方式。
                    'password' => $config->mongo->password, // 覆盖$server字符串中的password段，如果password包含符号@时，选用此种方式。
                    'db' => $config->mongo->db // 覆盖$server字符串中的database段
                ];
                if (isset($config->mongo->replicaSet)) {
                    $options['replicaSet'] = $config->mongo->replicaSet; // 配置replicaSet名称
                }
                return new \MongoDB\Driver\Manager($uri, $options);
            });
        }

        if ($config->mongo->isCollection) {
            // Initialise the mongo DB connection.
            $di->setShared('mongo', function () use ($config) {
                if (!$config->mongo->username || !$config->mongo->password) {
                    $dsn = 'mongodb://' . $config->mongo->host;
                } else {
                    $dsn = sprintf(
                        'mongodb://%s:%s@%s',
                        $config->mongo->username,
                        $config->mongo->password,
                        $config->mongo->host
                    );
                }

                $mongo = new Client($dsn);

                return $mongo->selectDatabase($config->mongo->db);
            });

            // Collection Manager is required for MongoDB
            $di->setShared('collectionManager', function () {
                return new Manager();
            });
        }
    }
}
