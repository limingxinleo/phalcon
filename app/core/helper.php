<?php
// +----------------------------------------------------------------------
// | 助手函数 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
use limx\Support\Arr;

if (!function_exists('app')) {
    /**
     * @desc   获取app配置文件的值
     * @author limx
     * @param $id
     * @return null
     */
    function app($id)
    {
        $app = di('app');
        return Arr::get($app, $id);
    }
}
