<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/9 Time: 9:55
// +----------------------------------------------------------------------
use limx\func\Debug;
use limx\phalcon\Ajax;
use limx\func\Arr;


if (!function_exists('dump')) {
    /**
     * [dump desc]
     * @desc 标准化的数组输出格式
     * @author limx
     * @param $data
     */
    function dump($data)
    {
        Debug::dump($data);
    }
}

if (!function_exists('success')) {

    /**
     * [success desc]
     * @desc
     * @author limx
     * @param $data
     * @return \limx\phalcon\JsonResponse
     */
    function success($data = [])
    {
        return Ajax::success($data);
    }
}

if (!function_exists('error')) {

    /**
     * [error desc]
     * @desc
     * @author limx
     * @param $data
     * @return \limx\phalcon\JsonResponse
     */
    function error($msg = '', $data = [])
    {
        return Ajax::error($msg, $data);
    }
}


if (!function_exists('app')) {
    /**
     * [app desc]
     * @desc 获取app配置文件的值
     * @author limx
     * @param $id
     * @return null
     */
    function app($id)
    {
        $app = di('app');
        return Arr::get($id, $app);
    }
}

if (!function_exists('dispatch_error')) {
    /**
     * [dispatch_error]
     * @desc 内部跳转错误页面
     * @author limx
     * @param int $code
     * @param string $msg
     */
    function dispatch_error($code = 500, $msg = '')
    {
        $dispatcher = di('dispatcher');
        $dispatcher->forward([
            'namespace' => 'MyApp\Controllers',
            "controller" => "error",
            "action" => "index",
            'params' => [$code, $msg],
        ]);
    }
}

if (!function_exists('library')) {
    /**
     * [library desc]
     * @desc 载入library内的第三方包
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

