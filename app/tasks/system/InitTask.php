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
use limx\phalcon\Utils\Str;
use Phalcon\Cli\Task;

class InitTask extends Task
{
    /**
     * @desc   初始化命名空间
     * @author limx
     */
    public function mainAction()
    {
        echo Color::head('Help:') . PHP_EOL;
        echo Color::colorize('  系统初始化脚本') . PHP_EOL . PHP_EOL;

        echo Color::head('Usage:') . PHP_EOL;
        echo Color::colorize('  php run Test\\\\Init [action]', Color::FG_GREEN) . PHP_EOL . PHP_EOL;

        echo Color::head('Actions:') . PHP_EOL;
        echo Color::colorize('  storage                         初始化仓库', Color::FG_GREEN) . PHP_EOL;
        echo Color::colorize('  namespace                       初始化命名空间', Color::FG_GREEN) . PHP_EOL;
        echo Color::colorize('  key     [key] [--random|val]    初始化配置参数', Color::FG_GREEN) . PHP_EOL;
    }

    /**
     * @desc   初始化仓库
     * @author limx
     */
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

    /**
     * @desc   初始化命名空间
     * @author limx
     */
    public function namespaceAction()
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

    /**
     * @desc   初始化配置KEY
     * @author limx
     */
    public function keyAction($params = [])
    {
        if (count($params) < 2) {
            echo Color::error("请输入要初始化的KEY与VAL");
            return false;
        }
        $key = strtoupper($params[0]);
        $val = static::random($params[1]);
        echo Color::head($key . '初始化') . PHP_EOL;
        $pattern = "/^{$key}=.*/m";
        file_put_contents(ROOT_PATH . '/.env', preg_replace(
            $pattern,
            $key . '=' . $val,
            file_get_contents(ROOT_PATH . '/.env')
        ));
        echo Color::success($key . " was successfully changed.");

    }

    private static function random($val)
    {
        $len = rand(12, 50);
        $res = $val;
        switch ($val) {
            case "--random-base64":
                $res = base64_encode(Str::random($len));
                break;

            case "--random-md5":
                $res = md5(Str::random($len));
                break;

            case "--random":
                $res = Str::random($len);
                break;

            default:
                break;
        }
        return $res;
    }

}
