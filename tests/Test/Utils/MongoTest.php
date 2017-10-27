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

    public function insert($id, $name)
    {
        $document = [
            'id' => $id,
            'name' => $name,
            'timed' => Mongo::datetime()
        ];
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

}