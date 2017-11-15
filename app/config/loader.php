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
            'App\Controllers' => $config->application->controllersDir,
            'App\Jobs' => $config->application->jobsDir,
            'App\Library' => $config->application->libraryDir,
            'App\Models' => $config->application->modelsDir,
            'App\Tasks' => $config->application->tasksDir,
            'App\Utils' => $config->application->utilsDir,
            'App\Core' => $config->application->coreDir,
            'App\Middleware' => $config->application->middlewareDir,
        ]
    )->registerFiles(
        [
            'function' => $config->application->coreDir . 'helper.php',
        ]
    )->register();
