<?php
// +----------------------------------------------------------------------
// | TRAIT RESPONSE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2017/1/8 Time: 上午11:31
// +----------------------------------------------------------------------
namespace MyApp\Traits\System;

use limx\phalcon\Ajax;

trait Response
{
    static function success($data = [], $type = 'json')
    {
        switch (strtolower($type)) {
            case 'json':
            default:
                return Ajax::success($data);
        }
    }

    static function error($msg = '', $data = [], $type = 'json')
    {
        switch (strtolower($type)) {
            case 'json':
            default:
                return Ajax::error($msg, $data);
        }
    }
}