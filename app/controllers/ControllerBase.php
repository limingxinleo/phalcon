<?php
// +----------------------------------------------------------------------
// | 控制器基类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;
use MyApp\Traits\System\Response;

class ControllerBase extends Controller
{
    use Response;

    public function initialize()
    {
    }
}
