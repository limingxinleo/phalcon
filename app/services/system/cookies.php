<?php
// +----------------------------------------------------------------------
// | COOKIES [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/18 Time: 15:21
// +----------------------------------------------------------------------
use Phalcon\Http\Response\Cookies;

$di->set(
    "cookies",
    function () use ($config) {
        $cookies = new Cookies();

        $cookies->useEncryption($config->cookies->isCrypt);

        return $cookies;
    }
);


