<?php
// +----------------------------------------------------------------------
// | 缓存清除脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks\System;

use App\Utils\Redis;
use Phalcon\Cli\Task;
use Xin\Cli\Color;

class ClearTask extends Task
{
    public $description = '系统清理脚本';

    public function mainAction()
    {
        $this->helpAction();
    }

    public function helpAction()
    {
        echo Color::head('Help:') . PHP_EOL;
        echo Color::colorize('  清理缓存信息') . PHP_EOL . PHP_EOL;

        echo Color::head('Usage:') . PHP_EOL;
        echo Color::colorize('  php run System\\\\Clear [action] [yes or no]', Color::FG_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        echo Color::head('Actions:') . PHP_EOL;
        echo Color::colorize('  data    清理数据缓存', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  view    清理视图缓存', Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize('  meta    清理模型元数据缓存', Color::FG_LIGHT_GREEN) . PHP_EOL;
    }

    public function dataAction($params)
    {
        $cache = di('cache');
        $list = $cache->queryKeys();

        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo Color::head('缓存列表', Color::FG_LIGHT_GREEN) . PHP_EOL;
            for ($i = 0; $i < 10; $i++) {
                if (empty($list[$i])) {
                    break;
                }
                echo Color::colorize('  缓存文件：' . $list[$i], Color::FG_LIGHT_GREEN) . PHP_EOL;
            }
            echo Color::colorize('  缓存总个数：' . count($list), Color::FG_LIGHT_GREEN) . PHP_EOL;
            echo Color::colorize('确定要删除么？(yes or no)', Color::FG_LIGHT_RED) . PHP_EOL;

            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        $result = $cache->flush();
        if ($result) {
            echo Color::success("The Cache was successfully deleted.");
        }
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
            echo Color::head('确定要清楚视图缓存么？', Color::FG_LIGHT_GREEN) . PHP_EOL;
            echo Color::colorize('  文件：' . $dir, Color::FG_LIGHT_GREEN) . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        static::rm($dir, false);
        echo Color::success("The Cache was successfully deleted.");
    }

    /**
     * @desc   清理元数据缓存
     * @author limx
     * @param array $params
     */
    public function metaAction($params = [])
    {
        $driver = $this->config->modelMeta->driver;
        switch (strtolower($driver)) {
            case 'redis':
                Redis::select($this->config->modelMeta->index);
                $keys = Redis::smembers($this->config->modelMeta->statsKey);
                foreach ($keys as $key) {
                    Redis::del("_PHCR" . $key);
                }
                break;
            case 'file':
            default:
                $dir = di('config')->application->metaDataDir;
                if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
                    echo Color::head('确定要清楚模型元数据缓存么？', Color::FG_LIGHT_GREEN) . PHP_EOL;
                    echo Color::colorize('  文件：' . $dir, Color::FG_LIGHT_GREEN) . PHP_EOL;
                    $arg = trim(fgets(STDIN));
                    if (strtolower($arg) !== 'yes') {
                        return;
                    }
                }
                // 删除缓存
                static::rm($dir, false);
                break;
        }

        echo Color::success("The Cache was successfully deleted.");
    }

    /**
     * @desc   递归删除某个文件夹下的文件
     * @author limx
     * @param $src      目录地址
     * @param $isDelDir 是否删除当前文件夹
     * @return bool
     */
    private static function rm($src, $isDelDir = true)
    {
        if (empty($src)) {
            return false;
        }
        $ls = scandir($src);
        for ($i = 0; $i < count($ls); $i++) {
            if ($ls[$i] == '.' || $ls[$i] == '..') {
                continue;
            }
            $_dst = $src . $ls[$i];
            if (!is_dir($_dst)) {
                unlink($_dst);
            } else {
                static::rm($_dst);
            }
        }
        //删除当前文件夹：
        if ($isDelDir) {
            rmdir($src);
        }
    }

}