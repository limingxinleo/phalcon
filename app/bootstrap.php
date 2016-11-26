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
use Phalcon\DI\FactoryDefault;

/** @var phalcon 容器  $di */
$di = new FactoryDefault();

/** Read vendor autoload */
if (file_exists(BASE_PATH . "/vendor/autoload.php")) {
    include BASE_PATH . "/vendor/autoload.php";
}

/** Read the configuration */
$config = include APP_PATH . "/config/config.php";

/** Read auto-loader */
include APP_PATH . "/config/loader.php";

/** Read services */
include APP_PATH . "/config/services.php";
include APP_PATH . "/config/services_web.php";