<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/10 Time: 9:45
// +----------------------------------------------------------------------
namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public static $tasks = [
        ['class' => \MyApp\Tasks\System\InitTask::class, 'action' => 'storageAction', 'params' => []]
    ];

    public function mainAction()
    {
        foreach (self::$tasks as $task) {
            $className = $task['class'];
            $class = new $className();
            call_user_func_array([$class, $task['action']], $task['params']);
        }
    }

}