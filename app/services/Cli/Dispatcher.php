<?php
// +----------------------------------------------------------------------
// | Dispatcher.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Services\Cli;

use App\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Dispatcher implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        /**
         * Set the default namespace for dispatcher
         */
        $di->setShared('dispatcher', function () {
            $dispatcher = new \Phalcon\Cli\Dispatcher();
            $dispatcher->setDefaultNamespace('App\\Tasks');
            return $dispatcher;
        });
    }

}