<?php
// +----------------------------------------------------------------------
// | ServiceProviderInterface.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Services;

use Phalcon\DI\FactoryDefault;
use Phalcon\Config;

interface ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config);
}