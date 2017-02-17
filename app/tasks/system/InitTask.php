<?php
// +----------------------------------------------------------------------
// | InitTask 初始化脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/10 Time: 11:07
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use limx\phalcon\Cli\Color;
use Phalcon\Cli\Task;

class InitTask extends Task
{
    public function mainAction()
    {
        echo Color::head('命名空间初始化') . PHP_EOL;
        echo Color::colorize('  默认的命名空间是MyApp', Color::BG_GREEN) . PHP_EOL;
        echo Color::colorize('  确定要重写命名空间么？(yes or no)', Color::BG_GREEN) . PHP_EOL;
        $arg = trim(fgets(STDIN));
        if ($arg == 'yes') {
            echo Color::colorize('请输入您的命名空间', Color::BG_GREEN) . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (!empty($arg)) {
                $res = [];
                traverse(APP_PATH, $res);
                foreach ($res as $v) {
                    $file = file_get_contents($v);
                    $file = str_replace('MyApp', $arg, $file);
                    file_put_contents($v, $file);
                }
            }
        }
        echo Color::success("You're now flying with Phalcon.");
    }

    public function storageAction()
    {
        $config = di('config')->application;
        $creatRoot = [
            'cache.data' => $config->cacheDir . 'data/',
            'cache.view' => $config->cacheDir . 'view/',
            'log' => $config->logDir,
            'meta' => $config->metaDataDir,
            'migrations' => $config->migrationsDir,
        ];
        echo Color::head('仓库初始化') . PHP_EOL;
        foreach ($creatRoot as $i => $v) {
            if (!is_dir($v)) {
                mkdir($v, 0777, true);
                echo Color::colorize(sprintf("  新建%s成功", $i), Color::BG_GREEN) . PHP_EOL;
            }
        }
        echo Color::success("The Storage was successfully created.");
    }

}