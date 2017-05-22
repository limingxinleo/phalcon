<?php
// +----------------------------------------------------------------------
// | Crypt 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
use Phalcon\Crypt;

$di->setShared(
    "crypt",
    function () use ($config) {
        $crypt = new Crypt();

        $crypt->setKey($config->crypt->key); // 使用你自己的key！

        return $crypt;
    }
);