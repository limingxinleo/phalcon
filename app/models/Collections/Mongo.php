<?php
// +----------------------------------------------------------------------
// | Mongo.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Models\Collections;

use Phalcon\Mvc\MongoCollection;

abstract class Mongo extends MongoCollection
{
    /**
     * Returns collection name mapped in the model
     *
     * @return string
     */
    public function getSource()
    {
        // 返回 Mongo 表名
    }
}
