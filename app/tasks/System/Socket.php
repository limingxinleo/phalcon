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

    public function mainAction()
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }
        set_time_limit(0);
        $server = new swoole_server("0.0.0.0", $this->port);

        $server->set(array(
            'worker_num' => 1,
            'daemonize' => false,
            'backlog' => 128,
        ));

        $server->on('Connect', function (swoole_server $server, $fd, $from_id) {
            /**
             * $request->fd     客户端的socket id
             * $request->header 请求的头文件
             * $request->server WebSocket 服务器信息
             * $request->data   客户端发送的数据
             */
            $this->connect($server, $fd, $from_id);
        });

        $server->on('Receive', function (swoole_server $server, $fd, $reactor_id, $data) {
            /**
             * $frame->fd       客户端的socket id，使用$server->push推送数据时需要用到
             * $frame->data     数据内容，可以是文本内容也可以是二进制数据，可以通过opcode的值来判断
             * $frame->opcode   WebSocket的OpCode类型，可以参考WebSocket协议标准文档
             * $frame->finish   表示数据帧是否完整，一个WebSocket请求可能会分成多个数据帧进行发送
             */
            $this->receive($server, $fd, $reactor_id, $data);
        });

        $server->on('Close', function (swoole_server $server, $fd, $reactorId) {
            /**
             * $fd 客户端的socket id，使用$server->push推送数据时需要用到
             */
            $this->close($server, $fd, $reactorId);
        });

        $this->ready($server);

        $server->start();
    }

    /**
     * @desc
     * @author limx
     * @param swoole_server $server
     * @param int           $fd
     * @param int           $from_id
     * @return mixed
     */
    abstract protected function connect(swoole_server $server, $fd, $from_id);

    /**
     * @desc
     * @author limx
     * @param swoole_server $server
     * @param int           $fd
     * @param int           $reactor_id
     * @param string        $data
     * @return mixed
     */
    abstract protected function receive(swoole_server $server, $fd, $reactor_id, $data);


    /**
     * @desc
     * @author limx
     * @param swoole_server $server
     * @param int           $fd
     * @param int           $reactorId
     * @return mixed
     */
    abstract protected function close(swoole_server $server, $fd, $reactorId);

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