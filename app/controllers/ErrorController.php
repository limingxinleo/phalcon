<?php
// +----------------------------------------------------------------------
// | ERROR 控制器 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/15 Time: 15:13
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{

    public function show404Action()
    {
        return $this->view->render('public', '404');
    }
}