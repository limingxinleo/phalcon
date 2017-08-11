<?php

namespace App\Tasks;

use App\Tasks\System\Queue;
use limx\phalcon\Redis;

class QueueTask extends Queue
{
    // 最大进程数
    protected $maxProcesses = 2;

    // 子进程最大循环处理次数
    protected $processHandleMaxNumber = 100;

    public function onConstruct()
    {
        $config = di('config')->queue;
        $this->queueKey = $config->key;
        $this->delayKey = $config->delay_key;
    }

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
        $obj = unserialize($recv);
        $obj->handle();
    }
}

