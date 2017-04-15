<?php
// +----------------------------------------------------------------------
// | ERROR 控制器 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

use MyApp\Traits\System\Response;

class ErrorController extends \Phalcon\Mvc\Controller
{
    use Response;

    /**
     * @desc   404
     * @author limx
     * @return bool|\Phalcon\Mvc\View
     */
    public function show404Action()
    {
        if ($this->request->isPost()) {
            return self::error('页面找不到了~');
        }
        return $this->view->render('public', '404');
    }

    /**
     * @desc   View方式返回错误
     * @author limx
     * @param string $code
     * @param string $msg
     * @return bool|\Phalcon\Mvc\View
     */
    public function indexAction($code = '500', $msg = '出错了')
    {
        $this->view->code = $code;
        $this->view->msg = $msg;
        return $this->view->render('public', 'error');
    }

    /**
     * @desc   json方式返回错误
     * @author limx
     * @param $status
     * @param $msg
     * @param $data
     * @return mixed
     */
    public function jsonAction($status = 0, $msg = "", $data = [])
    {
        return self::response($status, $data, $msg);
    }
}