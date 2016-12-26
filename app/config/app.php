<?php
// +----------------------------------------------------------------------
// | APP ENV [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/9 Time: 10:47
// +----------------------------------------------------------------------
return [
    'project-name' => 'limx-phalcon-ss-project',
    // 项目打包 配置文件
    'package-config' => [
        // 项目根目录
        'root' => BASE_PATH,
        // 需要打包的相对文件夹
        'files' => [
            'app/controllers',
            'app/config/app.php',
            'app/library',
            'app/models',
            'app/tasks',
            'app/views',
            'public',
            'composer.json',
        ],
        // 复制后的文件地址
        // 样例地址 E:\phpStudy\WWW\zips\laravel
        // 压缩地址为 E:\phpStudy\WWW\zips\laravel.zip
        'dst' => 'E:\phpStudy\WWW\zips\phalcon',
        // 版本号
        'vi' => '0.1',
    ],
    // 定时执行的脚本
    'cron-tasks' => [
        // ['class' => MyApp\Tasks\System\CronTask::class, 'action' => 'testAction', 'params' => []],
    ],
];