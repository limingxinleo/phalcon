<?php
// +----------------------------------------------------------------------
// | ERROR 控制器 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{

    public function show404Action()
    {
        if ($this->request->isPost()) {
            return error('页面找不到了~');
        }
        return $this->view->render('public', '404');
    }

    public function indexAction($code = '500', $msg = '出错了')
    {
        $this->view->code = $code;
        $this->view->msg = $msg;
        return $this->view->render('public', 'error');
    }
}