<?php
// +----------------------------------------------------------------------
// | CacheBase.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Support;

use App\Utils\Cache;
use Phalcon\Di\Injectable;
use Phalcon\Text;

abstract class CacheBase extends Injectable
{
    // 超时时间
    protected static $lifeTime = 60;

    public static function __callStatic($method, $parameters)
    {
        $object = (new static);
        if (Text::endsWith($method, 'FromCache')) {
            $method = substr($method, 0, strlen($method) - 9);
            $cacheKey = $object->getCacheKey($method, $parameters);
            $lifetime = static::$lifeTime;
            if (Cache::exists($cacheKey, $lifetime)) {
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
     * 清除方法缓存【暂时不可用】
     * @param string $method
     */
    protected function clearMethodCache($method)
    {
        $cacheKey = get_class($this) . ':' . $method . ':%';

        return Cache::delete($cacheKey);
    }

    /**
     * 清除类缓存【暂时不可用】
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
        if ($this->config->cache->type == 'file') {
            return md5(get_class($this)) . '-' . $method . '-' . sha1(json_encode($parameters));
        }
        return get_class($this) . ':' . $method . ':' . sha1(json_encode($parameters));
    }
}