<?php
// +----------------------------------------------------------------------
// | 基础 逻辑类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Logics;

use App\Utils\Cache;
use limx\phalcon\Utils\Str;
use Phalcon\Di\Injectable;

class Base extends Injectable
{
    // 超时时间
    protected static $lifeTime = 60;

    public static function __callStatic($method, $parameters)
    {
        $object = (new static);
        if (Str::ends_with($method, 'FromCache')) {
            $method = substr($method, 0, strlen($method) - 9);
            $cacheKey = $object->getCacheKey($method, $parameters);
            $lifetime = self::$lifeTime;
            if (Cache::exists($cacheKey)) {
                return Cache::get($cacheKey, $lifetime);
            }
            $result = $object->$method(...$parameters);
            Cache::save($cacheKey, $result, $lifetime);
            return $result;
        }

        return $object->$method(...$parameters);
    }

    /**
     * 清除缓存
     * @param string $method
     * @param        true /false
     */
    protected function clearCache($method, $parameters)
    {
        $object = (new static);
        $cacheKey = $object->getCacheKey($method, $parameters);

        return Cache::delete($cacheKey);
    }

    /**
     * 清除方法缓存
     * @param string $method
     * @param        true /false
     */
    protected function clearMethodCache($method)
    {
        $cacheKey = get_class($this) . ':' . $method . ':%';

        return Cache::delete($cacheKey);
    }

    /**
     * 清除类缓存
     */
    protected function clearClassCache()
    {
        $cacheKey = get_class($this) . ':%';

        return Cache::delete($cacheKey);
    }


    /**
     * 清除类缓存
     * @param string $method
     * @param        true /false
     */
    protected function clearAllCache()
    {
        return Cache::flush();
    }

    /**
     * 生成业务缓存Key
     * @param string $method
     * @param array  $parameters
     * @return string
     */
    private function getCacheKey($method, $parameters)
    {
        return get_class($this) . ':' . $method . ':' . sha1(json_encode($parameters));
    }
}