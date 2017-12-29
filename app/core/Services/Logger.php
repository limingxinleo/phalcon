<?php
// +----------------------------------------------------------------------
// | Logger.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Xin\Phalcon\Logger\Factory;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Logger implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        /**
         *  $factory = di('logger');
         *  $logger = $factory->getLogger('info', Sys::LOG_ADAPTER_FILE, ['dir' => 'system']);
         *  $logger->info('日志测试');
         */
        $di->setShared('logger', function () use ($config) {
            return new Factory($config);
        });
    }
}
