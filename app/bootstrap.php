<?php
// +----------------------------------------------------------------------
// | BOOTSTRAP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
defined('APP_PATH') || define('APP_PATH', __DIR__);
use Phalcon\DI\FactoryDefault;

/** @var phalcon 容器  $di */
$di = new FactoryDefault();

/** Read the configuration */
$config = include APP_PATH . "/config/config.php";

/** 设置时区 */
ini_set('date.timezone', $config->timezone);

/** Read auto-loader */
include APP_PATH . "/config/loader.php";

/** Read services */
include APP_PATH . "/config/services.php";
include APP_PATH . "/config/web/services.php";

return $di;