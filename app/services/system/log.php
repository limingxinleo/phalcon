<?php
// +----------------------------------------------------------------------
// | 注册日志服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/11 Time: 10:09
// +----------------------------------------------------------------------
use Phalcon\Events\Manager as EventsManager;
use MyApp\Listeners\System\DbListener;

if ($config->log->db) {
    $db = di('db');
    $eventsManager = new EventsManager();
    // 创建一个数据库侦听
    $dbListener = new DbListener();
    // 侦听全部数据库事件
    $eventsManager->attach(
        "db",
        $dbListener
    );
    $db->setEventsManager($eventsManager);
}
