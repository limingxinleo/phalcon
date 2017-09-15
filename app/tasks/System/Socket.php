<?php
// +----------------------------------------------------------------------
// | WebSocket 抽象类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Tasks\System;

use Phalcon\Cli\Task;
use limx\phalcon\Cli\Color;
use swoole_server;

abstract class Socket extends Task
{
    // 端口号
    protected $port = 11520;

    // @see https://wiki.swoole.com/wiki/page/274.html Swoole文档Socket配置选项
    protected $config = [];

    public function mainAction()
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }
        set_time_limit(0);
        $server = new swoole_server("0.0.0.0", $this->port);

        $server->set($this->config);

        foreach ($this->events() as $name => $callback) {
            $server->on($name, $callback);
        }
        $this->ready($server);

        $server->start();
    }

    /**
     * @desc   事件绑定
     * @author limx
     * @return array $events [ 'connect' => callback ]
     * @see    https://wiki.swoole.com/wiki/page/41.html Swoole文档Socket事件回调
     */
    abstract protected function events();

    /**
     * @desc   准备开启服务器
     * @author limx
     * @param swoole_websocket_server $server
     */
    protected function ready(swoole_server $server)
    {
        echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize("     Socket服务器开启 端口：{$this->port}     ", Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
    }
}