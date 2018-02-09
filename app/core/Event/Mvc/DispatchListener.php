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
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use App\Core\Event\DispatchListener as Listener;

/**
 * MVC调度器
 * Class DispatchListener
 * @package App\Core\Event\Mvc
 */
class DispatchListener extends Listener
{
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        // 代替控制器或者动作不存在时的路径
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                /** @var Response $response */
                $response = di('response');
                $response->setStatusCode(404);
                return false;

            default:
                break;
        }
    }
}
