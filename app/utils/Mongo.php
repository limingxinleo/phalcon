<?php
// +----------------------------------------------------------------------
// | Mongo.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils;

use App\Utils\Contract\MongoInteface;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Driver\Query;
use MongoDB\Driver\WriteConcern;
use MongoDB\Driver\BulkWrite;

class Mongo implements MongoInteface
{
    protected static function manager()
    {
        return di('mongoManager');
    }

    protected static function config()
    {
        return di('config')->mongo;
    }

    protected static function getNamespace($table, $db = null)
    {
        if (!isset($db)) {
            $db = static::config()->db;
        }

        return sprintf('%s.%s', $db, $table);
    }

    /**
     * @desc   查询
     * @author limx
     * @param $filter
     * @param $options
     * @return array(obj,obj)
     *
     *  $filter = ['id' => ['$gt' => 1]];
     *  $options = [
     *      'projection' => ['_id' => 0],
     *      'sort' => ['id' => -1],
     *      'limit' => 1,
     *  ];
     */
    public static function query($table, $filter = [], $options = [])
    {
        $manager = static::manager();
        $namespace = static::getNamespace($table);
        $query = new Query($filter, $options);

        $cursor = $manager->executeQuery($namespace, $query);

        return $cursor->toArray();
    }

    /**
     * @desc   插入数据
     * @author limx
     * @param       $document
     * @param  bool $single
     * @return \MongoDB\Driver\WriteResult;
     */
    public static function insert($table, $document, $single = true)
    {
        $manager = static::manager();
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $namespace = static::getNamespace($table);

        if ($single) {
            $bulk->insert($document);
        } else {
            foreach ($document as $doc) {
                $bulk->insert($doc);
            }
        }

        return $manager->executeBulkWrite($namespace, $bulk, $writeConcern);
    }

    /**
     * @desc
     * @author limx
     * @param       $table
     * @param       $filter
     * @param       $newObj
     * @param array $updateOptions
     * @return \MongoDB\Driver\WriteResult;
     *
     *  $document = ['name' => uniqid()];
     *  $filter = ['id' => 999];
     *  $options = [
     *      'upsert' => true,
     *      'multi' => true,
     *  ];
     */
    public static function update($table, $filter, $newObj, array $updateOptions = [])
    {
        $manager = static::manager();
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $namespace = static::getNamespace($table);

        $bulk->update($filter, ['$set' => $newObj], $updateOptions);

        return $manager->executeBulkWrite($namespace, $bulk, $writeConcern);
    }

    /**
     * @desc
     * @author limx
     * @param       $table
     * @param       $filter
     * @param array $deleteOptions
     * @return \MongoDB\Driver\WriteResult;
     */
    public static function delete($table, $filter, array $deleteOptions = [])
    {
        $manager = static::manager();
        $writeConcern = new WriteConcern(WriteConcern::MAJORITY, 1000);
        $bulk = new BulkWrite();
        $namespace = static::getNamespace($table);

        $bulk->delete($filter, $deleteOptions);

        return $manager->executeBulkWrite($namespace, $bulk, $writeConcern);
    }

    /**
     * @desc   获取mongodb的时间类型
     * @author limx
     * @param  int $microtime 毫秒数 microtime(true) * 1000
     */
    public static function datetime($microtime = null)
    {
        if (!isset($microtime)) {
            $microtime = microtime(true) * 1000;
        }
        return new UTCDateTime($microtime);
    }


}