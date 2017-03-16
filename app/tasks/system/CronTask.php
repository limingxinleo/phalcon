<?php
// +----------------------------------------------------------------------
// | CronTask 定时器脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/12/25 Time: 16:53
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use Phalcon\Cli\Task;
use limx\func\Str;
use limx\phalcon\Cli\Color;
use limx\phalcon\Logger;

class CronTask extends Task
{
    public function mainAction()
    {
        $time = date('H:i');
        $tasks = app('cron-tasks');

        foreach ($tasks as $task) {
            if (Str::contains($task['time'], $time) || $task['time'] === '') {
                $this->logInfo(json_encode($task));
                $this->console->handle($task);
            }
        }
    }

    /**
     * @desc   保存日志
     * @author limx
     * @param $msg
     */
    protected function logInfo($msg)
    {
        $logger = Logger::getInstance('file', 'cron.log', 'system');
        $logger->info($msg);
        echo Color::success($msg);
    }

}