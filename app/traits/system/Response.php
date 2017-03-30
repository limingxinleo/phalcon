<?php
// +----------------------------------------------------------------------
// | RESPONSE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace MyApp\Traits\System;

use limx\phalcon\Http\Response as HttpResponse;

trait Response
{
    protected static function success($data = [], $type = 'json')
    {
        return HttpResponse::send(1, $data, '', $type);
    }

    protected static function error($msg = '', $data = [], $type = 'json', $status = 0)
    {
        return HttpResponse::send($status, $data, $msg, $type);
    }
}