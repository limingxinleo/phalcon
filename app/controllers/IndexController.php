<?php
// +----------------------------------------------------------------------
// | 默认控制器 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace App\Controllers;

use App\Logics\Common;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->view->version = (new Common())->version();
        return $this->view->render('index', 'index');
    }
}