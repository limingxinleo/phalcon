<?php
// +----------------------------------------------------------------------
// | ENV [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/11 Time: 13:21
// +----------------------------------------------------------------------
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

if ($config->env->type) {
    $file = $config->env->path;
    if (file_exists($file . '/.env')) {
        (new Dotenv($file))->load();
    }
}