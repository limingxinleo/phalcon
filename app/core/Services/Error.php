<?php
// +----------------------------------------------------------------------
// | Error 捕获服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use App\Core\Exception\HandleExceptions;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Error implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        if ($config->log->error) {
            $handler = new HandleExceptions();
            $handler->bootstrap($di);
        }
    }

}