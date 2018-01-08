<?php
// +----------------------------------------------------------------------
// | SqlCount.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App\Common;

use Xin\Traits\Common\InstanceTrait;

class SqlCount
{
    use InstanceTrait;

    public $count = 0;

    public function add()
    {
        $this->count++;
    }

    public function flush()
    {
        $this->count = 0;
    }
}
