<?php
// +----------------------------------------------------------------------
// | 调度器 LISTENER [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Event\Mvc;

use Phalcon\Events\Event;
use Exception;
use Phalcon\Mvc\Dispatcher;

class DispatchListener
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // 在每一个找到的动作前执行
    }

    public function afterExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // 在每一个找到的动作后执行
    }

    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        // 代替控制器或者动作不存在时的路径
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward(
                    [
                        'namespace' => 'App\Controllers',
                        'controller' => 'error',
                        'action' => 'show404',
                    ]
                );
                return false;

            default:
                break;
        }
    }
}