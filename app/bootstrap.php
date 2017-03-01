<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/26 Time: 20:07
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