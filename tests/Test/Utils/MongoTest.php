<?php
// +----------------------------------------------------------------------
// | DBTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Utils;

use App\Utils\Mongo;
use \UnitTestCase;

class MongoTest extends UnitTestCase
{
    public $table = 'user';

    public function setUp()
    {
        parent::setUp();
        $filter = [];
        Mongo::delete($this->table, $filter);
    }

    public function insert($id, $name, $ext = [])
    {
        $document = [
            'id' => $id,
            'name' => $name,
            'timed' => Mongo::datetime()
        ];
        $document = array_merge($document, $ext);

        Mongo::insert($this->table, $document);
    }

    public function testGtQuery()
    {
        static::insert(2, 'limx');
        static::insert(1, 'Agnes');

        $filter = ['id' => ['$gt' => 1]];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => -1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('limx', $res[0]->name);
        }
    }

    public function testGteQuery()
    {
        static::insert(2, 'limx');
        static::insert(1, 'Agnes');

        $filter = ['id' => ['$gte' => 1]];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('Agnes', $res[0]->name);
        }
    }

    public function testExistQuery()
    {
        static::insert(2, 'limx', ['book' => '三天放弃PHP']);
        static::insert(1, 'Agnes');

        $filter = [
            'id' => ['$gte' => 1],
            'book' => ['$exists' => true]
        ];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('limx', $res[0]->name);
        }
    }

    public function testAllQuery()
    {
        static::insert(1, 'wxh', ['ids' => [1, 2, 3]]);
        static::insert(2, 'Agnes', ['ids' => [1, 2, 3, 4, 5]]);
        static::insert(3, 'limx', ['ids' => [1, 2, 3, 4]]);

        $filter = [
            'ids' => ['$all' => [1, 2, 3, 4]]
        ];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('Agnes', $res[0]->name);
        }
    }

    public function testSizeQuery()
    {
        static::insert(1, 'wxh', ['ids' => [1, 2, 3]]);
        static::insert(2, 'Agnes', ['ids' => [1, 2, 3, 4, 5]]);
        static::insert(3, 'limx', ['ids' => [1, 2, 3, 4]]);

        $filter = [
            'ids' => ['$size' => 4]
        ];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('limx', $res[0]->name);
        }
    }

    public function testAndQuery()
    {
        static::insert(1, 'wxh', ['ids' => [1, 2, 3]]);
        static::insert(2, 'Agnes', ['ids' => [1, 2, 3, 4, 5]]);
        static::insert(3, 'limx', ['ids' => [1, 2, 3, 4]]);
        static::insert(4, 'Agnes', ['ids' => [1, 2, 3, 4]]);

        $filter = [
            '$and' => [
                ['ids' => ['$size' => 4]],
                ['name' => 'Agnes']
            ],
        ];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('Agnes', $res[0]->name);
        }
    }

    public function testWhereQuery()
    {
        static::insert(1, 'wxh', ['uid' => 1]);
        static::insert(2, 'Agnes', ['uid' => 2]);
        static::insert(3, 'limx', ['uid' => 4]);
        static::insert(4, 'Agnes', ['uid' => 4]);

        $filter = [
            '$where' => 'this.uid - this.id > 0',
        ];
        $options = [
            'projection' => ['_id' => 0],
            'sort' => ['id' => 1],
            'limit' => 1,
        ];
        $res = Mongo::query($this->table, $filter, $options);

        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('limx', $res[0]->name);
        }
    }

    public function testUpdate()
    {
        static::insert(1, 'wxh', ['uid' => 1]);
        $filter = [
            'id' => 1,
        ];
        $set = [
            'name' => 'limx'
        ];
        $res = Mongo::update($this->table, $filter, $set);
        $this->assertTrue($res->getModifiedCount() === 1);
        $res = Mongo::query($this->table, $filter);
        $this->assertTrue(count($res) > 0);
        if (count($res) > 0) {
            $this->assertEquals('limx', $res[0]->name);
        }
    }

}