<?php
// +----------------------------------------------------------------------
// | Common 逻辑类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Logics;

class Common extends Base
{
    /**
     * @desc   获取项目版本号
     * @author limx
     * @return mixed
     */
    public static function version()
    {
        $object = (new static);
        return $object->config->version;
    }

}