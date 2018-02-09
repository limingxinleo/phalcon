<?php
// +----------------------------------------------------------------------
// | Request.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services\Mvc;

use App\Core\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Request implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('request', function () {
            $request = new \Xin\Phalcon\Http\Request();
            return $request;
        });
    }
}
