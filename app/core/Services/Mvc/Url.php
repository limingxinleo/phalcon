<?php
// +----------------------------------------------------------------------
// | Url 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services\Mvc;

use App\Core\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlResolver;

class Url implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        /**
         * The URL component is used to generate all kind of urls in the application
         */
        $di->setShared('url', function () use ($config) {
            $url = new UrlResolver();
            $url->setBaseUri($config->application->baseUri);

            return $url;
        });
    }
}
