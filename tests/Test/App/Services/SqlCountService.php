<?php
// +----------------------------------------------------------------------
// | SqlCountService.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App\Services;

use App\Core\Event\DbListener;
use Tests\Test\App\Common\SqlCount;
use Xin\Traits\Common\InstanceTrait;
use Phalcon\Events\Manager as EventsManager;

class SqlCountService
{
    use InstanceTrait;

    public function resetDbService()
    {
        /** @var \Phalcon\Db\Adapter\Pdo\Mysql $db */
        $db = di('db');

        $eventsManager = new EventsManager();
        // 侦听全部数据库事件
        $eventsManager->attach(
            "db:afterQuery",
            function () {
                SqlCount::getInstance()->add();
            }
        );

        $db->setEventsManager($eventsManager);

        SqlCount::getInstance()->flush();
    }

    public function rollbackDbService()
    {
        /** @var \Phalcon\Db\Adapter\Pdo\Mysql $db */
        $db = di('db');

        $eventsManager = new EventsManager();
        // 侦听全部数据库事件
        $eventsManager->attach(
            "db", new DbListener()
        );

        $db->setEventsManager($eventsManager);
    }
}
