<?php
// +----------------------------------------------------------------------
// | 打包脚本 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use limx\tools\Package as Pack;
use Phalcon\Cli\Task;

class PackageTask extends Task
{
    private $config = [
        'root' => ROOT_PATH, // 项目根目录
        // 需要打包的相对文件夹
        'files' => [
            'app',
            'public',
            'composer.json',
        ],
        // 复制后的文件地址
        // 样例地址 /Users/limx/Applications/zips/phalcon
        // 压缩地址为 /Users/limx/Applications/zips/phalcon.zip
        'dst' => '/Users/limx/Applications/zips/phalcon',
        // 版本号
        'vi' => '0.1',
    ];

    public function mainAction()
    {
        $pack = new Pack($this->config);
        $pack->run();
    }

}
