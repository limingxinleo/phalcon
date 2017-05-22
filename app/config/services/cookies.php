<?php
// +----------------------------------------------------------------------
// | Cookie 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
use Phalcon\Http\Response\Cookies;

$di->setShared(
    "cookies",
    function () use ($config) {
        $cookies = new Cookies();

        $cookies->useEncryption($config->cookies->isCrypt);

        return $cookies;
    }
);


