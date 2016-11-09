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
use Phalcon\Di\FactoryDefault as DI;
use limx\func\Debug;
use limx\phalcon\Ajax;

if (!function_exists('di')) {
    /**
     * [di desc]
     * @desc 获取容器对象
     * @author limx
     * @param $name 容器服务名
     * @return mixed
     */
    function di($name)
    {
        $di = DI::getDefault();
        return $di[$name];
    }
}

if (!function_exists('session')) {

    /**
     * [session desc]
     * @desc 获取注册后的session服务
     * @author limx
     * @param null $key
     * @param null $value
     * @return null
     */
    function session($key = null, $value = null)
    {
        $session = di('session');

        if (is_null($key)) {
            return null;
        }
        if (is_null($value)) {
            return $session->get($key);
        }
        return $session->set($key, $value);
    }
}

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
    function success($data)
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
    function error($data)
    {
        return Ajax::error($data);
    }
}


