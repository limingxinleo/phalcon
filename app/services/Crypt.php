<?php
// +----------------------------------------------------------------------
// | Crypt.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Crypt implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared(
            "crypt",
            function () use ($config) {
                $crypt = new \Phalcon\Crypt();

                $crypt->setKey($config->crypt->key); // 使用你自己的key！

                return $crypt;
            }
        );
    }

}