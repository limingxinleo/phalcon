<?php
// +----------------------------------------------------------------------
// | Redis工具类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils;

use Xin\Redis\Commands\IncrByWithExpireTimeCommand;
use Xin\Redis\Commands\IncrWithExpireTimeCommand;

class Redis
{
    public static function __callStatic($name, $arguments)
    {
        $redis = di('redis');
        return call_user_func_array([$redis, $name], $arguments);
    }

    /**
     * @desc   因为Redis工具类使用的是一个redis实例
     *         所以当我们在某个区块修改了redis的db，其他也会受到影响。所以这里增加一个辅助函数。
     *         可以让redis的db更改为配置里的db。
     * @author limx
     */
    public static function end()
    {
        $redis = di('redis');
        $db = di('config')->redis->index;
        return $redis->select($db);
    }

    public static function incr($key, $expiretime = null)
    {
        $redis = di('redis');
        if (isset($expiretime)) {
            $command = new IncrWithExpireTimeCommand($key, $expiretime);
            return $redis->evaluate($command->getScript(), $command->getArguments(), $command->getNumKeys());
        }
        return $redis->incr($key);
    }

    public static function incrBy($key, $number, $expiretime = null)
    {
        $redis = di('redis');
        if (isset($expiretime)) {
            $command = new IncrByWithExpireTimeCommand($key, $number, $expiretime);
            return $redis->evaluate($command->getScript(), $command->getArguments(), $command->getNumKeys());
        }
        return $redis->incrBy($key, $number);
    }
}
