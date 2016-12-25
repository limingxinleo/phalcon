<?php
// +----------------------------------------------------------------------
// | PackageTask 打包脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/10 Time: 10:56
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use Phalcon\Cli\Task;
use limx\tools\Package as Pack;

class PackageTask extends Task
{
    public function mainAction()
    {
        $app = di('app');
        if (empty($app['package-config'])) {
            echo 'please rewrite your config';
            return;
        }
        $config = $app['package-config'];
        $config['vi'] = di('config')->version;
        $pack = new Pack($config);
        $pack->run();
    }

}