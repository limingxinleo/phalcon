<?php
// +----------------------------------------------------------------------
// | DBTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Utils;

use App\Utils\DB;
use Test\App\Utils\DB1;
use \UnitTestCase;
use PDO;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Events\Manager as EventsManager;
use App\Listeners\DbListener;

class DbTest extends UnitTestCase
{
    public function testBaseCase()
    {
        $sql = "SELECT * FROM `user`;";
        $res = DB::query($sql);
        $this->assertTrue(count($res) > 0);
    }

    public function testDb1Case()
    {
        // 增加db1 服务
        $di = di();
        $config = di('config');

        $di->setShared('db1', function () use ($config) {
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


        $sql = "SELECT * FROM `user`;";
        $res = DB1::query($sql);
        $this->assertTrue(count($res) > 0);
    }
}