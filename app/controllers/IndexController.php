<?php
// +----------------------------------------------------------------------
// | PHALCON-PROJECT [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/8 Time: 11:18
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->version = di('config')->version;
        return $this->view->render('index', 'index');
    }

}