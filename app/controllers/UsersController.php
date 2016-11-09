<?php

namespace MyApp\Controllers;

use limx\phalcon\DB;
use MyApp\Models\User;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
        echo '[' . __METHOD__ . ']';
    }

    public function testAction()
    {
        $user = User::findFirst(1);
        dump($user->username);
        dump($this->app['project-name']);
        $this->session->set("user-name", "Michael");
        $name = $this->session->get("user-name");
        dump($name);
        dump(session('user-name'));

        dump(di('app'));

        $sql = "SELECT * FROM user WHERE id = ?;";
        //$res = di('db')->query($sql, [1]);
        //dump($res->fetchAll());
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
