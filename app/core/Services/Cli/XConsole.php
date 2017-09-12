<?php
// +----------------------------------------------------------------------
// | XConsole.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services\Cli;

use App\Core\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Xin\Phalcon\Cli\XConsole as XConsoleApp;

class XConsole implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        $di->setShared('xconsole', function () use ($di) {
            return new XConsoleApp($di);
        });
    }

}