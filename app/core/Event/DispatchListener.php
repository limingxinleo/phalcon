<?php
// +----------------------------------------------------------------------
// | Dispatcher.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Event;

use Phalcon\Events\Event;
use Exception;
use Phalcon\Mvc\Dispatcher;

/**
 * 自定义调度器
 * Class Dispatcher
 * @package App\Core\Event
 * @method beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
 * @method beforeDispatch(Event $event, Dispatcher $dispatcher)
 * @method beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
 * @method afterExecuteRoute(Event $event, Dispatcher $dispatcher)
 * @method beforeNotFoundAction(Event $event, Dispatcher $dispatcher)
 * @method afterDispatch(Event $event, Dispatcher $dispatcher)
 * @method afterDispatchLoop(Event $event, Dispatcher $dispatcher)
 * @method beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
 */
abstract class DispatchListener
{
}
