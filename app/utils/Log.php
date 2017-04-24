<?php
// +----------------------------------------------------------------------
// | Log.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Utils;

use limx\phalcon\Logger;

class Log
{
    /** 日志目录 */
    const DIR = null;

    /** 文件名 */
    const FILE_NAME = "logger.log";

    /** 日志类型 */
    const TYPE = "file";

    public static function logger()
    {
        return Logger::getInstance(static::TYPE, static::FILE_NAME, static::DIR);
    }

    public static function log($type, $message = null, array $context = null)
    {
        $logger = static::logger();
        return $logger->log($type, $message, $context);
    }

    public static function begin()
    {
        $logger = static::logger();
        return $logger->begin();
    }

    public static function commit()
    {
        $logger = static::logger();
        return $logger->commit();
    }

    public static function rollback()
    {
        $logger = static::logger();
        return $logger->rollback();
    }

    public static function debug($message, $context = null)
    {
        $logger = static::logger();
        return $logger->debug($message, $context);
    }

    public static function error($message, $context = null)
    {
        $logger = static::logger();
        return $logger->error($message, $context);
    }

    public static function info($message, $context = null)
    {
        $logger = static::logger();
        return $logger->info($message, $context);
    }

    public static function notice($message, $context = null)
    {
        $logger = static::logger();
        return $logger->notice($message, $context);
    }

    public static function warning($message, $context = null)
    {
        $logger = static::logger();
        return $logger->warning($message, $context);
    }

    public static function alert($message, $context = null)
    {
        $logger = static::logger();
        return $logger->alert($message, $context);
    }

    public static function emergency($message, $context = null)
    {
        $logger = static::logger();
        return $logger->emergency($message, $context);
    }


}