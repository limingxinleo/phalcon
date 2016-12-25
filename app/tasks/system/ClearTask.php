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
use limx\func\File;

class ClearTask extends Task
{
    public function mainAction()
    {
        echo "Please input the clear action" . PHP_EOL;
    }

    public function dataAction($params = [])
    {
        $dir = di('config')->application->cacheDir . 'data/';
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo 'Do you want to delete cache of view?(yes or no)' . PHP_EOL;
            echo $dir . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        File::rm($dir, false);
        echo 'delete cache success' . PHP_EOL;
    }

    /**
     * [viewAction desc]
     * @desc 清理视图缓存
     * @author limx
     * @param array $params
     */
    public function viewAction($params = [])
    {
        $dir = di('config')->application->cacheDir . 'view/';
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo 'Do you want to delete cache of view?(yes or no)' . PHP_EOL;
            echo $dir . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        File::rm($dir, false);
        echo 'delete cache success' . PHP_EOL;
    }

    /**
     * [metaAction desc]
     * @desc 清理元数据缓存
     * @author limx
     * @param array $params
     */
    public function metaAction($params = [])
    {
        $dir = di('config')->application->metaDataDir;
        if (empty($params[0]) || strtolower($params[0]) !== 'yes') {
            echo 'Do you want to delete meta?(yes or no)' . PHP_EOL;
            echo $dir . PHP_EOL;
            $arg = trim(fgets(STDIN));
            if (strtolower($arg) !== 'yes') {
                return;
            }
        }
        // 删除缓存
        File::rm($dir, false);
        echo 'delete cache success' . PHP_EOL;
    }

}