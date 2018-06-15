<?php
// +----------------------------------------------------------------------
// | Handler.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Exception;

use Exception;
use ErrorException;
use Phalcon\DI\FactoryDefault;
use Phalcon\Http\ResponseInterface;
use Xin\Phalcon\Logger\Sys;

class Handler
{
    public static $_instance;

    public $di;

    public $logger;

    private function __construct()
    {
        $this->di = FactoryDefault::getDefault();
        $this->logger = di('logger')->getLogger('error', Sys::LOG_ADAPTER_FILE);
    }

    public static function getInstance()
    {
        if (isset(static::$_instance) && static::$_instance instanceof Handler) {
            return static::$_instance;
        }
        return static::$_instance = new static();
    }

    /**
     * @desc   捕获Http模式 异常
     * @author limx
     * @param Exception $ex
     */
    public function render(Exception $ex)
    {
        $msg = $ex->getMessage() . ' code:' . $ex->getCode() . ' in ' . $ex->getFile() . ' line ' . $ex->getLine() . PHP_EOL . $ex->getTraceAsString();
        $this->logger->error($msg);

        $message = 'Sorry, 服务器内部错误';
        if (di('config')->get('debug', false)) {
            $message = $msg;
        }

        /** @var ResponseInterface $response */
        $response = di('response');
        $response->setContent($message)->send();
    }

    /**
     * @desc   捕获Cli模式 异常
     * @author limx
     * @param Exception $ex
     */
    public function renderForConsole(Exception $ex)
    {
        $msg = $ex->getMessage() . ' code:' . $ex->getCode() . ' in ' . $ex->getFile() . ' line ' . $ex->getLine() . PHP_EOL . $ex->getTraceAsString();
        $this->logger->error($msg);
        echo $msg;
    }
}
