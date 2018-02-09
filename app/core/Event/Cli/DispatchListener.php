<?php
// +----------------------------------------------------------------------
// | 调度器 LISTENER [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Event\Cli;

use Phalcon\Events\Event;
use Exception;
use Phalcon\Cli\Dispatcher;
use Xin\Phalcon\Cli\Tasks\NotFindTask;
use App\Core\Event\DispatchListener as Listener;

class DispatchListener extends Listener
{
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        // 代替控制器或者动作不存在时的路径
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:

                $this->handleTaskNotFind($event, $dispatcher, $exception);
                return false;
            default:
                break;
        }
    }

    /**
     * @desc   获取没有找到handler或者action时的默认Task
     * @author limx
     */
    protected function handleTaskNotFind(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        if (method_exists(NotFindTask::class, 'mainAction')) {
            $task = $dispatcher->getTaskName();
            $action = $dispatcher->getActionName();
            $tasksDir = di('config')->application->tasksDir;
            $namespace = $dispatcher->getDefaultNamespace();
            $dispatcher->forward([
                'namespace' => 'Xin\\Phalcon\\Cli\\Tasks',
                'task' => 'NotFind',
                'action' => 'main',
                'params' => [
                    'tasksDir' => $tasksDir,
                    'namespace' => $namespace,
                    'taskName' => $task,
                    'actionName' => $action,
                ]
            ]);
        } else {
            echo $exception->getMessage() . PHP_EOL;
            echo $exception->getTraceAsString();
        }
    }
}
