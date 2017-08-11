<?php

namespace App\Tasks;

use App\Tasks\System\Queue;
use limx\phalcon\Redis;

class QueueTask extends Queue
{
    // 消息队列Redis键值 list lpush添加队列
    protected $queueKey = 'queue-default';
    // 延时消息队列的Redis键值 zset
    protected $delayKey = '';

    protected function redisClient()
    {
        $config = di('config')->redis;
        return Redis::getInstance($config->host, $config->auth, $config->index, $config->port);
    }

    protected function redisChildClient()
    {
        $config = di('config')->redis;
        return Redis::getInstance($config->host, $config->auth, $config->index, $config->port, uniqid());
    }

    protected function handle($recv)
    {
        $config = di('config')->redis;
    }
}

