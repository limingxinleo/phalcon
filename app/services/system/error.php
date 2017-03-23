<?php
// +----------------------------------------------------------------------
// | 错误捕获日志 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
if ($config->log->error) {
    register_shutdown_function(function () {
        if ($e = error_get_last()) {
            $log = $e['message'] . " in " . $e['file'] . ' line ' . $e['line'];
            logger($log, 'error', 'error.log');
        }
    });
}
