<?php
// +----------------------------------------------------------------------
// | Redis工具类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace MyApp\Utils;

class Redis
{
    public static function __callStatic($name, $arguments)
    {
        $redis = di('redis');
        return true;
    }
}