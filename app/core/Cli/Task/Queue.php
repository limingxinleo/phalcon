<?php
// +----------------------------------------------------------------------
// | 消息队列 REDIS抽象类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
declare(ticks=1);

namespace App\Core\Cli\Task;

use Phalcon\Cli\Task;
use Xin\Cli\Color;
use swoole_process;
use Xin\Support\File;

abstract class Queue extends Task
{
    // 最大进程数
    protected $maxProcesses = 500;
    // 当前进程数
    protected $process = 0;
    // 消息队列Redis键值 list lpush添加队列
    protected $queueKey = '';
    // 延时消息队列的Redis键值 zset
    protected $delayKey = '';
    // 子进程数到达最大值时的等待时间
    protected $waitTime = 1;
    // pid地址
    protected $pidPath;
    // 主进程PID
    protected $pid;
    // 子进程最大循环处理次数
    protected $processHandleMaxNumber = null;

    public function mainAction()
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }
        if (empty($this->queueKey)) {
            echo Color::error('Please rewrite the queueKey');
            return;
        }

        // 初始PID文件
        $this->pidPath = di('config')->application->pidsDir . 'queue' . '.pid';
        $this->pid = posix_getpid();
        // 写入PID
        File::getInstance()->put($this->pidPath, $this->pid);

        // install signal handler for dead kids
        pcntl_signal(SIGCHLD, [$this, "signalHandler"]);
        set_time_limit(0);
        // 实例化Redis实例
        $redis = $this->redisClient();
        while (true) {
            // 等待
            sleep($this->waitTime);

            // 监听延时队列
            if (!empty($this->delayKey) && $delay_data = $redis->zrangebyscore($this->delayKey, 0, time())) {
                foreach ($delay_data as $data) {
                    // 把可以执行的消息压入队列中
                    $redis->lpush($this->queueKey, $data);
                    $redis->zrem($this->delayKey, $data);
                }
            }
            // 监听消息队列
            if ($this->process < $this->maxProcesses) {
                // 获取消息列表数量
                $len = $redis->llen($this->queueKey);
                if ($len === 0) {
                    continue;
                }

                // fork子进程处理消息
                $process = new swoole_process([$this, 'task']);
                $pid = $process->start();
                if ($pid !== false) {
                    $this->process++;
                }
            }
        }
    }

    /**
     * @desc   子进程
     * @author limx
     * @param swoole_process $worker
     */
    public function task(swoole_process $worker)
    {
        $this->run($worker);

        // swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
        //     $this->run($worker);
        //     $worker->exit(0);
        //     swoole_event_del($pipe);
        // });
    }

    /**
     * @desc   主进程中操作数据
     * @tip    主进程中不能实例化DB类，因为Mysql连接会中断
     *         暂时原因不明，可能是会被子进程释放掉
     * @author limx
     * @param $data 消息队列中的数据
     * @return mixed 返回给子进程的数据
     */
    protected function rewrite($data)
    {
        return $data;
    }

    /**
     * @desc   返回redis实例
     * @author limx
     * @return mixed
     */
    abstract protected function redisClient();

    /**
     * @desc   子进程redis实例
     * @author limx
     * @return mixed
     */
    abstract protected function redisChildClient();

    /**
     * @desc   消息队列 业务逻辑处理
     * @author limx
     * @param $recv
     * @return mixed
     */
    abstract protected function handle($recv);

    /**
     * @desc   消息队列子进程逻辑
     * @author limx
     * @return mixed
     */
    protected function run(&$worker)
    {
        $redis = $this->redisChildClient();
        $number = 0;
        while (true) {
            // 判断主进程是否退出
            if (!swoole_process::kill($this->pid, 0)) {
                $worker->exit();
            }

            // 当子进程处理次数高于一个临界值后，释放进程
            if (isset($this->processHandleMaxNumber) && $this->processHandleMaxNumber < (++$number)) {
                break;
            }

            // 无任务时,阻塞等待
            $data = $redis->brpop($this->queueKey, 3);
            if (!$data) {
                break;
            }
            if ($data[0] != $this->queueKey) {
                // 消息队列KEY值不匹配
                continue;
            }
            if (isset($data[1])) {
                $this->handle($data[1]);
            }
        }
    }

    /**
     * @desc   信号处理方法 回收已经dead的子进程
     * @author limx
     * @param $signo
     */
    private function signalHandler($signo)
    {
        switch ($signo) {
            case SIGCHLD:
                while (swoole_process::wait(false)) {
                    $this->process--;
                }

            // no break
            default:
                break;
        }
    }
}
