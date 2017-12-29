<?php
// +----------------------------------------------------------------------
// | HandleExceptions.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Exception;

use Exception;
use ErrorException;
use Phalcon\DI\FactoryDefault;

class HandleExceptions
{
    /**
     * The application instance.
     *
     * @var FactoryDefault
     */
    protected $di;

    /**
     * Bootstrap the given application.
     *
     * @param  FactoryDefault $app
     * @return void
     */
    public function bootstrap(FactoryDefault $di)
    {
        $this->di = $di;

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Convert PHP errors to ErrorException instances.
     *
     * @param  int    $level
     * @param  string $message
     * @param  string $file
     * @param  int    $line
     * @param  array  $context
     * @return void
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception from the application.
     *
     * Note: Most exceptions can be handled via the try / catch block in
     * the HTTP and Console kernels. But, fatal error exceptions must
     * be handled differently since they are not normal exceptions.
     *
     * @param  \Throwable $e
     * @return void
     */
    public function handleException($e)
    {
        if (!$e instanceof Exception) {
            $e = new FatalThrowableError($e);
        }

        if (IS_CLI) {
            $this->renderForConsole($e);
        } else {
            $this->renderHttpResponse($e);
        }
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Exception $e
     * @return void
     */
    protected function renderForConsole(Exception $e)
    {
        $this->getExceptionHandler()->renderForConsole($e);
    }

    /**
     * Render an exception as an HTTP response and send it.
     *
     * @param  \Exception $e
     * @return void
     */
    protected function renderHttpResponse(Exception $e)
    {
        $this->getExceptionHandler()->render($e);
    }

    /**
     * Handle the PHP shutdown event.
     *
     * @return void
     */
    public function handleShutdown()
    {
        if (!is_null($error = error_get_last()) && $this->isFatal($error['type'])) {
            $this->handleException($this->fatalExceptionFromError($error));
        }
    }

    /**
     * Create a new fatal exception instance from an error array.
     *
     * @param  array    $error
     * @param  int|null $traceOffset
     * @return ErrorException
     */
    protected function fatalExceptionFromError(array $error, $traceOffset = null)
    {
        return new \ErrorException(
            $error['message'],
            $error['type'],
            0,
            $error['file'],
            $error['line'],
            $traceOffset
        );
    }

    /**
     * Determine if the error type is fatal.
     *
     * @param  int $type
     * @return bool
     */
    protected function isFatal($type)
    {
        return in_array($type, [E_COMPILE_ERROR, E_CORE_ERROR, E_ERROR, E_PARSE]);
    }

    /**
     * Get an instance of the exception handler.
     *
     * @return \App\Core\Exception\Handler
     */
    protected function getExceptionHandler()
    {
        return Handler::getInstance();
    }
}
