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
    /** @var null 日志目录 */
    protected $dir = null;

    /** @var string 文件名 */
    protected $fileName = "logger.log";

    /** @var string 日志类型 */
    protected $type = "file";

    public function __construct()
    {
        return Logger::getInstance($this->type, $this->fileName, $this->dir);
    }

    public static function log($type, $message = null, array $context = null)
    {
        $logger = new self();
        return $logger->log($type, $message, $context);
    }

    public static function begin()
    {
        $logger = new self();
        return $logger->begin();
    }

    public static function commit()
    {
        $logger = new self();
        return $logger->commit();
    }

    public static function rollback()
    {
        $logger = new self();
        return $logger->rollback();
    }

    public static function debug($message, $context = null)
    {
        $logger = new self();
        return $logger->debug($message, $context);
    }

    public static function error($message, $context = null)
    {
        $logger = new self();
        return $logger->error($message, $context);
    }

    public static function info($message, $context = null)
    {
        $logger = new self();
        return $logger->info($message, $context);
    }

    public static function notice($message, $context = null)
    {
        $logger = new self();
        return $logger->notice($message, $context);
    }

    public static function warning($message, $context = null)
    {
        $logger = new self();
        return $logger->warning($message, $context);
    }

    public static function alert($message, $context = null)
    {
        $logger = new self();
        return $logger->alert($message, $context);
    }

    public static function emergency($message, $context = null)
    {
        $logger = new self();
        return $logger->emergency($message, $context);
    }


}