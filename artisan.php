<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/8 Time: 9:36
// +----------------------------------------------------------------------
include 'vendor/autoload.php';
use limx\tools\Package;

$action = $argv[1];
switch ($action) {
    case 'make:limx-package':
        package();
        break;
}

function package()
{
    $config = [
        // 项目根目录
        'root' => __DIR__,
        // 需要打包的相对文件夹
        'files' => [
            'app/controllers',
            'app/models',
            'app/views',
            'public',
            'artisan.php',
            'worker.php',
            'composer.json',
        ],
        // 复制后的文件地址
        // 样例地址 E:\phpStudy\WWW\zips\laravel
        // 压缩地址为 E:\phpStudy\WWW\zips\laravel.zip
        'dst' => 'E:\phpStudy\WWW\zips\phalcon',
        // 版本号
        'vi' => '0.1',
    ];

    $pack = new Package($config);
    $pack->run();
}