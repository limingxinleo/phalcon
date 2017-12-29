<?php
// +----------------------------------------------------------------------
// | 日志工具类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils\Contract;

interface LogInteface
{

    /**
     * @desc   Sends/Writes messages to the file log
     * @author limx
     * @param  mixed      $type
     * @param  mixed      $message
     * @param  array|null $context
     * @return mixed
     */
    public static function log($type, $message = null, array $context = null);

    /**
     * @desc   Starts a transaction
     * @author limx
     * @return mixed
     */
    public static function begin();

    /**
     * @desc   Commits the internal transaction
     * @author limx
     * @return mixed
     */
    public static function commit();

    /**
     * @desc   Rollbacks the internal transaction
     * @author limx
     * @return mixed
     */
    public static function rollback();

    /**
     * @desc   Sends/Writes a debug message to the log
     * @author limx
     * @param  string $message
     * @param  array  $context
     * @return mixed
     */
    public static function debug($message, array $context = null);

    /**
     * @desc   Sends/Writes an error message to the log
     * @author limx
     * @param  string $message
     * @param  array  $context
     * @return mixed
     */
    public static function error($message, array $context = null);

    /**
     * @desc   Sends/Writes an info message to the log
     * @author limx
     * @param  string $message
     * @param  array  $context
     * @return mixed
     */
    public static function info($message, array $context = null);

    /**
     * @desc   Sends/Writes a notice message to the log
     * @author limx
     * @param  string     $message
     * @param  array|null $context
     * @return mixed
     */
    public static function notice($message, array $context = null);

    /**
     * @desc   Sends/Writes a warning message to the log
     * @author limx
     * @param  string     $message
     * @param  array|null $context
     * @return mixed
     */
    public static function warning($message, array $context = null);

    /**
     * @desc   Sends/Writes an alert message to the log
     * @author limx
     * @param  string     $message
     * @param  array|null $context
     * @return mixed
     */
    public static function alert($message, array $context = null);

    /**
     * @desc   Sends/Writes an emergency message to the log
     * @author limx
     * @param  string     $message
     * @param  array|null $context
     * @return mixed
     */
    public static function emergency($message, array $context = null);
}
