<?php
// +----------------------------------------------------------------------
// | Test.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Jobs;

use App\Jobs\Contract\JobInterface;

class Test implements JobInterface
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        echo $this->id . PHP_EOL;
    }

}