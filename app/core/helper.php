<?php
// +----------------------------------------------------------------------
// | 助手函数 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
use limx\phalcon\Http\Response;
use limx\Support\Arr;

if (!function_exists('success')) {

    /**
     * @desc
     * @author limx
     * @param array $data
     * @return mixed
     */
    function success($data = [])
    {
        return Response::send(1, $data);
    }
}

if (!function_exists('error')) {

    /**
     * @desc
     * @author limx
     * @param string $msg
     * @param array  $data
     * @return mixed
     */
    function error($msg = '', $data = [])
    {
        return Response::send(0, $data, $msg);
    }
}


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

if (!function_exists('dispatch_error')) {
    /**
     * @desc   内部跳转错误页面
     * @author limx
     * @param int    $code
     * @param string $msg
     */
    function dispatch_error($code = 500, $msg = '')
    {
        $error_msg = app(sprintf("error-code.%d", $code));
        if (empty($msg) && !empty($error_msg)) {
            $msg = $error_msg;
        }

        $dispatcher = di('dispatcher');
        $dispatcher->forward([
            'namespace' => 'App\Controllers',
            "controller" => "error",
            "action" => "index",
            'params' => [$code, $msg],
        ]);
    }
}

if (!function_exists('library')) {
    /**
     * @desc   载入library内的第三方包
     * @author limx
     * @param string $file
     */
    function library($file = '')
    {
        $root = di('config')->application->libraryDir;
        if (file_exists($root . $file)) {
            require_once $root . $file;
        }
    }
}

