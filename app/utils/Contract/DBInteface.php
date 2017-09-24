<?php
// +----------------------------------------------------------------------
// | DBInteface.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils\Contract;

interface DBInteface
{
    /**
     * @desc   查询结果集合
     * @author limx
     * @param       $sql
     * @param array $params
     * @return mixed
     */
    public static function query($sql, $params = [], $fetchMode = PDO::FETCH_ASSOC);

    /**
     * @desc   查询一条数据
     * @author limx
     * @param       $sql
     * @param array $params
     * @return mixed
     */
    public static function fetch($sql, $params = [], $fetchMode = PDO::FETCH_ASSOC);

    /**
     * @desc   更新数据
     * @author limx
     * @param       $sql          SQL语句
     * @param array $params       参数
     * @param bool  $withRowCount 是否返回影响的行数
     * @return int|mixed
     */
    public static function execute($sql, $params = [], $withRowCount = false);

    /**
     * @desc   执行Sql并返回影响的行数
     * @author limx
     * @param       $sql
     * @param array $params
     * @return int|mixed
     */
    public static function execWithRowCount($sql, $params = []);

    /**
     * @desc   事务开始
     * @author limx
     * @return mixed
     */
    public static function begin();

    /**
     * @desc   事务回滚
     * @author limx
     * @return mixed
     */
    public static function rollback();

    /**
     * @desc   事务提交
     * @author limx
     * @return mixed
     */
    public static function commit();
}