<?php
// +----------------------------------------------------------------------
// | Cache工具类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils\Contract;

interface CacheInteface
{
    /**
     * @desc   Returns a cached content
     * @author limx
     * @param string $keyName
     * @param int    $lifetime
     * @return mixed|null
     */
    public static function get($keyName, $lifetime = null);

    /**
     * @desc   Stores cached content into the file backend and stops the frontend
     * @author limx
     * @param int|string $keyName
     * @param string     $content
     * @param int        $lifetime
     * @param boolean    $stopBuffer
     * @return bool
     */
    public static function save($keyName = null, $content = null, $lifetime = null, $stopBuffer = true);

    /**
     * @desc   Deletes a value from the cache by its key
     * @author limx
     * @param int|string $keyName
     * @return bool
     */
    public static function delete($keyName);

    /**
     * @desc   Query the existing cached keys.
     * @author limx
     * @param string $prefix
     * @return array
     */
    public static function queryKeys($prefix = null);

    /**
     * @desc   Checks if cache exists and it isn't expired
     * @author limx
     * @param string|int $keyName
     * @param int        $lifetime
     * @return bool
     */
    public static function exists($keyName = null, $lifetime = null);

    /**
     * Increment of given $keyName by $value
     *
     * @param string $keyName
     * @param int    $value
     * @return int
     */
    public static function increment($keyName = null, $value = 1);

    /**
     * Decrement of $keyName by given $value
     *
     * @param string $keyName
     * @param int    $value
     * @return int
     */
    public function decrement($keyName = null, $value = 1);

    /**
     * Immediately invalidates all existing items.
     *
     * @return bool
     */
    public function flush();
}
