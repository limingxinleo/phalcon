<?php
// +----------------------------------------------------------------------
// | 项目信息查看脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks\System;

use App\Logics\System;
use Phalcon\Cli\Task;
use Xin\Cli\Color;

class InfoTask extends Task
{
    public $description = '项目信息脚本';

    /**
     * @desc   菜单
     * @author limx
     */
    public function mainAction()
    {
        echo Color::head('Help:') . PHP_EOL;
        echo Color::colorize('  项目信息脚本') . PHP_EOL . PHP_EOL;

        echo Color::head('Usage:') . PHP_EOL;
        echo Color::colorize('  php run System\\\\Info [action]', Color::FG_GREEN) . PHP_EOL . PHP_EOL;

        echo Color::head('Actions:') . PHP_EOL;
        echo Color::colorize('  version                         项目版本', Color::FG_GREEN) . PHP_EOL;
        echo Color::colorize('  annotations                     获取控制器方法注释', Color::FG_GREEN) . PHP_EOL;
    }

    public function annotationsAction()
    {
        echo Color::head("控制器方法获取:"), PHP_EOL;
        $res = System::getControllersAnnotations(0, true);
        foreach ($res as $method) {
            echo Color::colorize(sprintf("  方法名：%s", $method['method']), Color::FG_GREEN), PHP_EOL;
            if (isset($method['annotation'])) {
                foreach ($method['annotation'] as $annotation) {
                    echo Color::colorize(sprintf("  注释：%s", json_encode($annotation)), Color::FG_GREEN), PHP_EOL;
                }
            }
            echo PHP_EOL;
        }
        echo Color::colorize(sprintf("  共%d个方法。", count($res))), PHP_EOL;
    }

    public function versionAction()
    {
        echo Color::head("Environment:"), PHP_EOL;
        foreach (System::getEnvironment() as $k => $v) {
            echo Color::colorize(sprintf("  %s: %s", $k, $v), Color::FG_GREEN), PHP_EOL;
        }
        echo Color::head("Versions:"), PHP_EOL;
        foreach (System::getVersions() as $k => $v) {
            echo Color::colorize(sprintf("  %s: %s", $k, $v), Color::FG_GREEN), PHP_EOL;
        }
    }
}