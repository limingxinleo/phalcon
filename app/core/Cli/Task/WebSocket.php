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

abstract class WebSocket extends Task
{
    // 端口号
    protected $port = 11521;

    public function mainAction()
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }
        set_time_limit(0);
        $server = new swoole_websocket_server("0.0.0.0", $this->port);

        $server->on('open', function (swoole_websocket_server $server, $request) {
            /**
             * $request->fd     客户端的socket id
             * $request->header 请求的头文件
             * $request->server WebSocket 服务器信息
             * $request->data   客户端发送的数据
             */
            $this->connect($server, $request);
        });

        $server->on('message', function (swoole_websocket_server $server, swoole_websocket_frame $frame) {
            /**
             * $frame->fd       客户端的socket id，使用$server->push推送数据时需要用到
             * $frame->data     数据内容，可以是文本内容也可以是二进制数据，可以通过opcode的值来判断
             * $frame->opcode   WebSocket的OpCode类型，可以参考WebSocket协议标准文档
             * $frame->finish   表示数据帧是否完整，一个WebSocket请求可能会分成多个数据帧进行发送
             */
            $this->message($server, $frame);
        });

        $server->on('close', function ($ser, $fd) {
            /**
             * $fd 客户端的socket id，使用$server->push推送数据时需要用到
             */
            $this->close($ser, $fd);
        });

        $this->ready($server);

        $server->start();
    }

    /**
     * @desc    WebSocket 连接到服务器
     * @author  limx
     * @param swoole_websocket_server $server
     * @param                         $request
     */
    abstract protected function connect(swoole_websocket_server $server, $request);

    /**
     * @desc   WebSocket 收到客户端消息
     * @author limx
     * @param swoole_websocket_server $server
     * @param swoole_websocket_frame  $frame
     */
    abstract protected function message(swoole_websocket_server $server, swoole_websocket_frame $frame);

    /**
     * @desc   WebSocket 断开连接
     * @author limx
     * @param $ser
     * @param $fd
     * @return mixed
     */
    abstract protected function close($ser, $fd);

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
}