<?php
// +----------------------------------------------------------------------
// | Mongo.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils;

use MongoDB\Driver\Query;

class Mongo
{
    protected static function manager()
    {
        return di('mongoManager');
    }

    /**
     * @desc   查询
     * @author limx
     * @param $filter
     * @param $options
     *
     *  $filter = ['id' => ['$gt' => 1]];
     *  $options = [
     *      'projection' => ['_id' => 0],
     *      'sort' => ['id' => -1],
     *  ];
     */
    public static function query($table, $filter, $options)
    {
        $query = new Query($filter, $options);
        $cursor = static::manager()->executeQuery($table, $query);
        return $cursor;
    }
}