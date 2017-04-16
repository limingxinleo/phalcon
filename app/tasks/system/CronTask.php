<?php
// +----------------------------------------------------------------------
// | Cron定时服务脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks\System;

use Phalcon\Cli\Task;
use limx\phalcon\Utils\Str;
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