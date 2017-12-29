<?php
// +----------------------------------------------------------------------
// | App 配置服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services;

use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class App implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('app', function () {
            // 加载app.php 配置文件
            $app = APP_PATH . '/config/app.php';
            if (file_exists($app)) {
                $data = require $app;
                return new Config($data);
            }
            return new Config([]);
        });
    }
}
