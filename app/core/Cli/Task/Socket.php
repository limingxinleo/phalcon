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
use swoole_server;

/**
 * Class Socket SwooleServer 服务
 * @package App\Tasks\System
 * @reload  kill -USR1 `cat socket.pid`
 * @stop    kill `cat socket.pid`
 * @see     https://wiki.swoole.com/wiki/page/699.html
 */
abstract class Socket extends Task
{
    // 端口号
    protected $port = 11520;

    public function mainAction($params = [])
    {
        if (!extension_loaded('swoole')) {
            echo Color::error('The swoole extension is not installed');
            return;
        }

        set_time_limit(0);
        $server = new swoole_server("0.0.0.0", $this->port);

        $config = $this->getConfig();
        $server->set($config);

        foreach ($this->events() as $name => $callback) {
            $server->on($name, $callback);
        }

        $this->beforeServerStart($server);

        $server->start();
    }

    /**
     * @desc   服务启动前的注册事件
     * @author limx
     * @param swoole_server $server
     */
    protected function beforeServerStart(swoole_server $server)
    {
        $this->ready($server);
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

    /**
     * @desc   获取配置
     * @author limx
     * @see    https://wiki.swoole.com/wiki/page/274.html Server配置
     * @return array
     */
    protected function getConfig()
    {
        $pidsDir = di('config')->application->pidsDir;
        return [
            'pid_file' => $pidsDir . 'socket.pid',
            'user' => 'nginx',
            'group' => 'nginx',
            'daemonize' => false,
            'max_request' => 500,
        ];
    }
}
