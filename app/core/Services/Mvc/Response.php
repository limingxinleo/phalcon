<?php
// +----------------------------------------------------------------------
// | Request.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services\Mvc;

use App\Core\Http\Response\SwooleResponse;
use App\Core\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Http\Response as HttpResponse;

class Response implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('response', function () {
            if (defined('ENGINE') && ENGINE == 'SWOOLE') {
                return new SwooleResponse();
            }
            return new HttpResponse();
        });
    }
}
