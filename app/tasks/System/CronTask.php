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
use Xin\Cli\Color;
use limx\Support\Schedule;
use Xin\Phalcon\Logger\Sys;

class CronTask extends Task
{
    public $description = '定时器执行脚本';

    public function mainAction()
    {
        if (!class_exists(Schedule::class)) {
            echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
            echo Color::colorize("           Schedule 支持库不存在！           ", Color::FG_LIGHT_GREEN) . PHP_EOL;
            echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
            echo Color::head("请使用以下命令安装：") . PHP_EOL;
            echo Color::colorize("    composer require limingxinleo/support-schedule") . PHP_EOL;
            return;
        }

        $tasks = app('cron-tasks')->toArray();
        $schedule = new Schedule();
        foreach ($tasks as $task) {
            list($func, $params) = $task['schedule'];
            unset($task['schedule']);
            if ($schedule->$func(...$params)) {
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
        $factory = di('logger');
        $logger = $factory->getLogger('cron', Sys::LOG_ADAPTER_FILE);
        $logger->info($msg);
        echo Color::success($msg);
    }

}