<?php
// +----------------------------------------------------------------------
// | 默认脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public $description = '初始化脚本';

    public static $tasks = [
        ['task' => 'System\\Init', 'action' => 'storage', 'params' => []],
        ['task' => 'System\\Init', 'action' => 'key', 'params' => ['CRYPT_KEY', '--random']]
    ];

    public function mainAction()
    {
        foreach (static::$tasks as $task) {
            $this->console->handle($task);
        }
    }
}
