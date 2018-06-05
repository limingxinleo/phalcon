<?php

namespace App\Tasks;

use Xin\Phalcon\Logger\Factory;
use Xin\Swoole\Queue\Job;

class QueueTask extends Task
{
    public $queueKey;

    public $delayKey;

    public $errorKey;

    /** @var Job */
    protected $queue;

    public function onConstruct()
    {
        $config = di('config')->queue;
        $this->queueKey = $config->key;
        $this->delayKey = $config->delayKey;
        $this->errorKey = $config->errorKey;

        $queue = new Job();
        $redis = di('config')->redis;
        $pid = di('config')->application->pidsDir . 'queue' . '.pid';
        /** @var Factory $factory */
        $factory = di('logger');
        $logger = $factory->getLogger('queue-failed');

        $queue->setRedisConfig($redis->host, $redis->auth, $redis->index, $redis->port)
            ->setQueueKey($this->queueKey)
            ->setDelaykey($this->delayKey)
            ->setErrorKey($this->errorKey)
            ->setLoggerHandler($logger)
            ->setPidPath($pid);

        $this->queue = $queue;

        parent::onConstruct();
    }

    public function mainAction()
    {
        $this->queue->run();
    }

    /**
     * @desc   重载失败的Job
     * @author limx
     */
    public function reloadErrorJobsAction()
    {
        $this->queue->reloadErrorJobs();
    }

    /**
     * @desc   删除所有失败的Job
     * @author limx
     */
    public function flushErrorJobsAction()
    {
        $this->queue->flushErrorJobs();
    }
}
