<?php
// +----------------------------------------------------------------------
// | InstanceBase.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Support;

use Phalcon\Di\Injectable;

abstract class InstanceBase extends Injectable
{
    protected static $_instances = [];

    public static function getInstance()
    {
        $key = get_called_class();
        if (isset(static::$_instances[$key]) && static::$_instances[$key] instanceof InstanceBase) {
            return static::$_instances[$key];
        }
        return static::$_instances[$key] = new static();
    }
}
