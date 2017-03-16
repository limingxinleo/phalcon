<?php
// +----------------------------------------------------------------------
// | ClearTask 清理缓存脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/14 Time: 13:39
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use Phalcon\Cli\Task;
// use limx\func\File;
use limx\phalcon\Cli\Color;

class ClearTask extends Task
{
    public function mainAction()
    {
        echo Color::error("Please input the clear action");
    }

    public function helpAction()
    {
        echo Color::head('Help:') . PHP_EOL;
        echo Color::colorize('  清理缓存信息') . PHP_EOL . PHP_EOL;

        echo Color::head('Usage:') . PHP_EOL;
        echo Color::colorize('  php run System\\\\Clear [action] [yes or no]', Color::FG_GREEN) . PHP_EOL . PHP_EOL;

        echo Color::head('Actions:') . PHP_EOL;
        echo Color::colorize('  data    清理数据缓存', Color::FG_GREEN) . PHP_EOL;
        echo Color::colorize('  view    清理视图缓存', Color::FG_GREEN) . PHP_EOL;
        echo Color::colorize('  meta    清理模型元数据缓存', Color::FG_GREEN) . PHP_EOL;
    }

    public function dataAction($params = [])
    {
        $dir = di('config')->application->cacheDir . 'data/';
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo Color::head('确定要清楚数据缓存么？', Color::FG_GREEN) . PHP_EOL;
            echo Color::colorize('  文件：' . $dir, Color::FG_GREEN) . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        // File::rm($dir, false);
        $this->rm($dir, false);
        echo Color::success("The Cache was successfully deleted.");
    }

    /**
     * [viewAction desc]
     * @desc   清理视图缓存
     * @author limx
     * @param array $params
     */
    public function viewAction($params = [])
    {
        $dir = di('config')->application->cacheDir . 'view/';
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo Color::head('确定要清楚视图缓存么？', Color::FG_GREEN) . PHP_EOL;
            echo Color::colorize('  文件：' . $dir, Color::FG_GREEN) . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        // File::rm($dir, false);
        $this->rm($dir);
        echo Color::success("The Cache was successfully deleted.");
    }

    /**
     * [metaAction desc]
     * @desc   清理元数据缓存
     * @author limx
     * @param array $params
     */
    public function metaAction($params = [])
    {
        $dir = di('config')->application->metaDataDir;
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo Color::head('确定要清楚模型元数据缓存么？', Color::FG_GREEN) . PHP_EOL;
            echo Color::colorize('  文件：' . $dir, Color::FG_GREEN) . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        // File::rm($dir, false);
        $this->rm($dir);
        echo Color::success("The Cache was successfully deleted.");
    }

    private function rm($dir)
    {
        $str = "rm -rf " . $dir . "/*";
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $str = "rmdir /s/q " . $dir . "/*";
        }

        system($str);
    }

}