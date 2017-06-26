<?php
// +----------------------------------------------------------------------
// | 自动加载文件 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader
    ->registerNamespaces(
        [
            'App' => APP_PATH,
            'App\Services' => $config->application->servicesDir,
            'App\Controllers' => $config->application->controllersDir,
            'App\Library' => $config->application->libraryDir,
            'App\Listeners' => $config->application->listenersDir,
            'App\Logics' => $config->application->logicsDir,
            'App\Models' => $config->application->modelsDir,
            'App\Tasks' => $config->application->tasksDir,
            'App\Traits' => $config->application->traitsDir,
            'App\Utils' => $config->application->utilsDir,
        ]
    )->registerFiles(
        [
            'function' => $config->application->libraryDir . 'helper.php',
        ]
    )->register();
