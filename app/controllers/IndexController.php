<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/8 Time: 11:18
// +----------------------------------------------------------------------
namespace MyApp\Controllers;

use limx\phalcon\DB;
use MyApp\Models\User;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->version = di('config')->version;
        return $this->view->render('index', 'index');
    }

    public function testAction()
    {
        dump(env('TEST'));
        dump(di('config')->env);
        $user = User::findFirst(1);
        dump($user->username);
        dump($this->app['project-name']);
        $this->session->set("user-name", "Michael");
        $name = $this->session->get("user-name");
        dump($name);
        dump(session('user-name'));

        dump(di('app'));

        $sql = "SELECT * FROM user WHERE id = ?;";
        $res = DB::query($sql, [1]);
        dump($res);
        $sql = "UPDATE user SET username=? WHERE id=?;";
        $status = DB::execute($sql, [time(), 1]);
        dump($status);
        $sql = "SELECT * FROM user WHERE id = ?;";
        $res = DB::fetch($sql, [1]);
        dump($res);

        DB::begin();
        $sql = "UPDATE user SET username=? WHERE id=?;";
        $status = DB::execute($sql, [time() + 11, 1]);
        DB::rollback();
        $sql = "SELECT * FROM user WHERE id = ?;";
        $res = DB::fetch($sql, [1]);
        dump($res);

    }
}