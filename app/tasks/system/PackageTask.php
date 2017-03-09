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
    private $config = [
        'root' => BASE_PATH, // 项目根目录
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