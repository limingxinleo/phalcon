<?php

namespace App\Tasks;

use App\Jobs\Contract\JobInterface;
use App\Core\Cli\Task\Queue;
use Xin\Cli\Color;
use Xin\Redis;
use Exception;

class QueueTask extends Queue
{
    public $description = '默认消息执行脚本';

    // 最大进程数
    protected $maxProcesses = 2;

    // 子进程最大循环处理次数
    protected $processHandleMaxNumber = 100;

    protected $errorKey = '';

    public function onConstruct()
    {
        $config = di('config')->queue;
        $this->queueKey = $config->key;
        $this->delayKey = $config->delayKey;
        $this->errorKey = $config->errorKey;
    }

    protected function redisClient()
    {
        $config = di('config')->redis;
        return Redis::getInstance($config->host, $config->auth, $config->index, $config->port, 'queue');
    }

    protected function redisChildClient()
    {
        $config = di('config')->redis;
        return Redis::getInstance($config->host, $config->auth, $config->index, $config->port, uniqid());
    }

    protected function handle($recv)
    {
        try {
            $obj = unserialize($recv);
            if ($obj instanceof JobInterface) {
                $name = get_class($obj);
                echo Color::colorize('Processing: ' . $name, Color::FG_GREEN) . PHP_EOL;
                $obj->handle();
                echo Color::colorize('Processed: ' . $name, Color::FG_GREEN) . PHP_EOL;
            }
        } catch (Exception $ex) {
            $redis = static::redisChildClient();
            $redis->lpush($this->errorKey, $recv);
        }

    }

    /**
     * @desc   重载失败的Job
     * @author limx
     */
    public function reloadErrorJobsAction()
    {
        $redis = static::redisChildClient();
        while ($data = $redis->rpop($this->errorKey)) {
            $redis->lpush($this->queueKey, $data);
        }
        echo Color::success("失败的脚本已重新载入消息队列！");
    }

    /**
     * @desc   删除所有失败的Job
     * @author limx
     */
    public function flushErrorJobsAction()
    {
        $redis = static::redisChildClient();
        $redis->del($this->errorKey);
        echo Color::success("失败的脚本已被清除！");
    }
}

