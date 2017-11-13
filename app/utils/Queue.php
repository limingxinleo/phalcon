<?php
// +----------------------------------------------------------------------
// | Queue.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils;

class Queue
{
    public static function push($job)
    {
        $redis_key = di('config')->queue->key;
        return Redis::lpush($redis_key, serialize($job));
    }

    public static function delay($job, $second)
    {
        $redis_key = di('config')->queue->delayKey;
        return Redis::zadd($redis_key, time() + $second, serialize($job));
    }
}