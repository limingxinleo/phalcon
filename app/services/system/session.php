<?php
// +----------------------------------------------------------------------
// | SESSION [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/18 Time: 15:21
// +----------------------------------------------------------------------
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Session\Adapter\Redis as SessionRedis;

/**
 * Start the session the first time some component request the session service
 */
if ($config->session->type !== false) {
    $session = null;
    switch ($config->session->type) {
        case 'redis':
            $session = new SessionRedis([
                'uniqueId' => $config->unique_id,
                'host' => $config->redis->host,
                'port' => $config->redis->port,
                'auth' => $config->redis->auth,
                'persistent' => $config->redis->persistent,
                'lifetime' => 3600,
                'prefix' => ':session:',
                'index' => $config->redis->index,
            ]);
            break;
        case 'file':
        default:
            $session = new SessionAdapter();
            break;

    }
    if ($session !== null) {
        $session->start();
        $di->set('session', function () use ($session) {
            return $session;
        });
    }
}
