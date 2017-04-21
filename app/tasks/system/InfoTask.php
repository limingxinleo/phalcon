<?php
// +----------------------------------------------------------------------
// | 项目信息查看脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks\System;

use App\Logics\Common;
use Phalcon\Cli\Task;
use limx\phalcon\Cli\Color;
use Phalcon\Version;

class InfoTask extends Task
{
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
    }

    public function versionAction()
    {
        echo Color::head("Environment:"), PHP_EOL;
        foreach ($this->getEnvironment() as $k => $v) {
            echo Color::colorize(sprintf("  %s: %s", $k, $v), Color::FG_GREEN), PHP_EOL;
        }
        echo Color::head("Versions:"), PHP_EOL;
        foreach ($this->getVersions() as $k => $v) {
            echo Color::colorize(sprintf("  %s: %s", $k, $v), Color::FG_GREEN), PHP_EOL;
        }
    }

    private function getVersions()
    {
        return [
            'Phalcon Version' => Version::get(),
            'Project Version' => (new Common())->version(),
        ];
    }

    private function getEnvironment()
    {
        return [
            'OS' => php_uname(),
            'PHP Version' => PHP_VERSION,
            'PHP SAPI' => php_sapi_name(),
            'PHP Bin' => PHP_BINARY,
            'PHP Extension Dir' => PHP_EXTENSION_DIR,
            'PHP Bin Dir' => PHP_BINDIR,
            'Loaded PHP config' => php_ini_loaded_file(),
        ];
    }
}