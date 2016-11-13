<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/13 Time: 15:12
// +----------------------------------------------------------------------
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

if ($config->cache->type !== false) {
    $frontCache = new FrontData(
        [
            "lifetime" => $config->cache->lifetime,
        ]
    );
    $cache = null;
    switch (strtolower($config->cache->type)) {
        case 'file':
            $cache = new BackFile(
                $frontCache,
                [
                    "cacheDir" => $config->application->cacheDir . 'data/',
                ]
            );
            break;
        default:
            exit('Sorry! The cache engine is not support!');
            break;
    }
    if ($cache !== null) {
        // 注入容器
        $di->set('cache', function () use ($cache) {
            return $cache;
        });
    }
}