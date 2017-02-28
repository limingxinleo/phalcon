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
use Phalcon\Logger;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

if ($config->log->sql) {
    $dir = $config->application->logDir . date('Ymd');
    if (!is_dir($dir))
        mkdir($dir, 0777, true);
    $eventsManager = new EventsManager();
    $connection = di('db');
    $logger = new FileLogger($dir . "/sql.log");

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) use ($logger) {
            $sql = $connection->getSQLStatement();
            $logger->log($sql, Logger::INFO);
        }
    );

    // 设置事件管理器
    $connection->setEventsManager($eventsManager);

    // 创建一个数据库侦听
    $dbListener = new MyApp\Listeners\System\DbListener();
    // 侦听全部数据库事件
    $eventsManager->attach(
        "db",
        $dbListener
    );
}
