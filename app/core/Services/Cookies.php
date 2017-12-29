<?php
// +----------------------------------------------------------------------
// | Cookies 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Cookies implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared(
            "cookies",
            function () use ($config) {
                $cookies = new \Phalcon\Http\Response\Cookies();

                $cookies->useEncryption($config->cookies->isCrypt);

                return $cookies;
            }
        );
    }
}
