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
use App\Core\Event\DbListener;

class DbTest extends UnitTestCase
{
    public $table = 'test';

    public function setUp()
    {
        parent::setUp();
        if (!DB::tableExists('test')) {
            $sql = "CREATE TABLE `{$this->table}` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '姓名',
              `age` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年龄',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
            DB::execute($sql);
        }
    }

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

    public function testInsert()
    {
        $sql = "INSERT INTO {$this->table} (`name`,`age`) VALUES (?,?)";
        $res = DB::execute($sql, ['limx', 26]);
        $this->assertTrue($res);
    }

    public function testQuery()
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `name` = ? LIMIT 1;";
        $res = DB::query($sql, ['limx']);
        $this->assertTrue(count($res) > 0);
        $this->assertTrue(is_array($res));
    }

    public function testFetch()
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `name` = ? LIMIT 1;";
        $res = DB::fetch($sql, ['limx']);
        $this->assertTrue(is_array($res));

        $res = DB::fetch($sql, ['limx'], PDO::FETCH_OBJ);
        $this->assertTrue(is_object($res));
    }

    public function testExecute()
    {
        $sql = "INSERT INTO {$this->table} (`name`,`age`) VALUES (?,?)";
        $res = DB::execute($sql, ['Agnes', 25]);
        $this->assertTrue($res);

        $res = DB::execute($sql, ['Agnes', 25], true);
        $this->assertEquals(1, $res);

        $sql = "UPDATE {$this->table} SET age=? WHERE name =?";
        $res = DB::execute($sql, [26, 'Agnes'], true);
        $this->assertTrue(is_numeric($res));
    }

    public function testTableExist()
    {
        $this->assertTrue(DB::tableExists($this->table));
        $this->assertFalse(DB::tableExists('sss'));
    }
}