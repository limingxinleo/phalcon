<?php
// +----------------------------------------------------------------------
// | WebSocket 抽象类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Cli\Task;

use Phalcon\Cli\Task;
use Xin\Cli\Color;
use swoole_websocket_server;
use swoole_websocket_frame;
use swoole_http_request;

abstract class WebSocket extends Task
{
    // 端口号
    protected $port = 11521;

    // @see https://wiki.swoole.com/wiki/page/274.html Swoole文档Socket配置选项
    protected $config = [
        'pid_file' => ROOT_PATH . '/socket.pid',
        'user' => 'nginx',
        'group' => 'nginx',
        'daemonize' => false,
        // 'worker_num' => 8, // cpu核数1-4倍比较合理 不写则为cpu核数
        'max_request' => 500, // 每个worker进程最大处理请求次数
    ];

    public function mainAction()
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }
        set_time_limit(0);
        $server = new swoole_websocket_server("0.0.0.0", $this->port);

        $server->set($this->config);

        $server->on('open', [$this, 'connect']);

        $server->on('message', [$this, 'message']);

        $server->on('close', [$this, 'close']);

        $this->beforeServerStart($server);

        $server->start();
    }

    /**
     * @desc    WebSocket 连接到服务器
     * @author  limx
     * @param swoole_websocket_server $server
     * @param                         $request
     */
    abstract public function connect(swoole_websocket_server $server, swoole_http_request $request);

    /**
     * @desc   WebSocket 收到客户端消息
     * @author limx
     * @param swoole_websocket_server $server
     * @param swoole_websocket_frame  $frame
     */
    abstract public function message(swoole_websocket_server $server, swoole_websocket_frame $frame);

    /**
     * @desc   WebSocket 断开连接
     * @author limx
     * @param $ser
     * @param $fd
     * @return mixed
     */
    abstract public function close(swoole_websocket_server $ser, $fd);

    /**
     * @desc   准备开启服务器
     * @author limx
     * @param swoole_websocket_server $server
     */
    protected function ready(swoole_websocket_server $server)
    {
        echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize("     WebSocket服务器开启 端口：{$this->port} ", Color::FG_LIGHT_GREEN) . PHP_EOL;
        echo Color::colorize("-------------------------------------------", Color::FG_LIGHT_GREEN) . PHP_EOL;
    }

    protected function beforeServerStart(swoole_websocket_server $server)
    {
        $this->ready($server);
    }
}