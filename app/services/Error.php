<?php
// +----------------------------------------------------------------------
// | Error.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Services;

use App\Utils\Log;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;

class Error implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        if ($config->log->error) {
            register_shutdown_function(function () {
                if ($e = error_get_last()) {
                    $log = $e['message'] . " in " . $e['file'] . ' line ' . $e['line'];
                    logger($log, 'error', 'error.log');
                }
            });
        }
    }

}