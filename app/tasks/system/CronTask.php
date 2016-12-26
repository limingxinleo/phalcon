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

class CronTask extends Task
{
    public function mainAction()
    {
        $tasks = app('cron-tasks');
        foreach ($tasks as $task) {
            $className = $task['class'];
            $class = new $className();
            call_user_func_array([$class, $task['action']], $task['params']);
        }
    }
}