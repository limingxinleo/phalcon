<?php
// +----------------------------------------------------------------------
// | FatalThrowableError.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Exception;

use ErrorException;

/**
 * Fatal Throwable Error.
 *
 */
class FatalThrowableError extends ErrorException
{
    public function __construct(\Throwable $e)
    {
        if ($e instanceof \ParseError) {
            $message = 'Parse error: ' . $e->getMessage();
            $severity = E_PARSE;
        } elseif ($e instanceof \TypeError) {
            $message = 'Type error: ' . $e->getMessage();
            $severity = E_RECOVERABLE_ERROR;
        } else {
            $message = $e->getMessage();
            $severity = E_ERROR;
        }

        \ErrorException::__construct(
            $message,
            $e->getCode(),
            $severity,
            $e->getFile(),
            $e->getLine()
        );

        $this->setTrace($e->getTrace());
    }

    protected function setTrace($trace)
    {
        $traceReflector = new \ReflectionProperty('Exception', 'trace');
        $traceReflector->setAccessible(true);
        $traceReflector->setValue($this, $trace);
    }
}