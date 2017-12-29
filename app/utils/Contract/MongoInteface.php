<?php
// +----------------------------------------------------------------------
// | MongoInteface.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils\Contract;

interface MongoInteface
{
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
    public static function query($table, $filter = [], $options = []);

    /**
     * @desc   插入数据
     * @author limx
     * @param       $document
     * @param  bool $single
     * @return \MongoDB\Driver\WriteResult;
     */
    public static function insert($table, $document, $single = true);

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
    public static function update($table, $filter, $newObj, array $updateOptions = []);

    /**
     * @desc
     * @author limx
     * @param       $table
     * @param       $filter
     * @param array $deleteOptions
     * @return \MongoDB\Driver\WriteResult;
     */
    public static function delete($table, $filter, array $deleteOptions = []);

    /**
     * @desc   获取mongodb的时间类型
     * @author limx
     * @param  int $microtime 毫秒数 microtime(true) * 1000
     */
    public static function datetime($microtime = null);
}
