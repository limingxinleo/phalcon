<?php
// +----------------------------------------------------------------------
// | 基础服务文件 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Files as MetadataFiles;
use Phalcon\Events\Manager as EventsManager;
use MyApp\Listeners\System\DbListener;

/**
 * Shared configuration service
 */
$di->setShared('config', function () use ($config) {
    return $config;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    $db = new DbAdapter(
        [
            'host' => $config->database->host,
            'username' => $config->database->username,
            'password' => $config->database->password,
            'dbname' => $config->database->dbname,
            'charset' => $config->database->charset,
            'options' => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        ]
    );
    if ($config->log->db) {
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
    return $db;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () use ($config) {
    return new MetadataFiles(
        [
            'metaDataDir' => $config->application->metaDataDir,
        ]
    );
});

$di->set('app', function () {
    // 加载app.php 配置文件
    $app = APP_PATH . '/config/app.php';
    if (file_exists($app)) {
        return require $app;
    }
    return [];
});
