<?php
// +----------------------------------------------------------------------
// | Ins1.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\App\Logics;

use App\Core\Support\InstanceBase;

class Ins2 extends InstanceBase
{

    public function str()
    {
        return 'Ins2';
    }

    public function instance()
    {
        return static::$_instance;
    }
}