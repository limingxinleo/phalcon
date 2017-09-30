<?php
// +----------------------------------------------------------------------
// | RESPONSE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Controllers\Traits;

trait Response
{
    /**
     * @desc   返回JSON结构体
     * @author limx
     */
    protected static function getJsonBody($status, $data, $message)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message,
            'timestamp' => time(),
        ];
    }

    /**
     * @desc   成功返回数据
     * @author limx
     * @param array $data
     * @return mixed
     */
    protected static function success($data = [])
    {
        return di('response')->setJsonContent(static::getJsonBody(1, $data, ''));
    }

    /**
     * @desc   返回失败数据
     * @author limx
     * @param string $msg
     * @param array  $data
     * @param int    $status
     * @return mixed
     */
    protected static function error($msg = '', $data = [], $status = 0)
    {
        return di('response')->setJsonContent(static::getJsonBody($status, $data, $msg));
    }

    /**
     * @desc   返回自定义数据
     * @author limx
     * @param $status
     * @param $data
     * @param $msg
     * @return mixed
     */
    protected static function response($status, $data, $msg)
    {
        return di('response')->setJsonContent(static::getJsonBody($status, $data, $msg));
    }
}