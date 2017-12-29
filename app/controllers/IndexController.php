<?php
// +----------------------------------------------------------------------
// | 默认控制器 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace App\Controllers;

use App\Core\System;

class IndexController extends Controller
{
    /**
     * @desc
     * @author limx
     * @return bool|\Phalcon\Mvc\View
     * @Middleware('auth')
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {
            return $this->response->setJsonContent([
                'version' => System::getInstance()->version(),
                'message' => "You're now flying with Phalcon. Great things are about to happen!",
            ]);
        }
        $this->view->version = System::getInstance()->version();
        return $this->view->render('index', 'index');
    }
}
