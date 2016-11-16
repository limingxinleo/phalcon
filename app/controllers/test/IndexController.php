<?php

namespace MyApp\Controllers\Test;

use MyApp\Controllers\Test\ControllerBase;
use limx\phalcon\DB;
use MyApp\Models\User;
use limx\tools\wx\OAuth;

class IndexController extends ControllerBase
{
    public function initAction()
    {
        dump($this->settings);
    }

    public function indexAction()
    {
        $this->view->version = di('config')->version;
        return $this->view->render('index', 'index');
    }

    public function saveAction()
    {
        $user = User::findFirst(1);
        $this->view->setVars([
            'name' => $user->name
        ]);
        return $this->view->render('test/index', 'save');
    }

    public function postSaveAction()
    {
        $user = User::findFirst(1);
        $user->name = $this->request->get('name');
        if ($user->save() === true) {
            return success();
        }
        return error();
    }

    public function voltAction()
    {
        $this->view->app = 'limx';
        $this->view->setVars([
            'app2' => 'limx2'
        ]);

        return $this->view->render('test/index', 'index');
    }

    public function mrAction()
    {
        return $this->response->redirect('index/model');

    }

    public function modelAction()
    {
        $user = User::findFirst([
            'conditions' => 'id=?0',
            'bind' => [
                1
            ],
        ]);
        dump($user->username);
        $user->username = '李铭昕';
        if ($user->save() === false) {
            dump($user->getMessages());
        }
    }

    public function cacheAction()
    {
        $config = di('config')->cache;
        dump($config);

        dump(di('cache')->get('test_1'));
        di('cache')->save('test_1', ['text' => 'Cache Test', 'time' => time()]);

        dump(di('cache')->queryKeys());
    }

    public function urlAction()
    {
        $url = $this->url->get('index/getParams', ['key1' => 1111, 'key2' => 222]);
        dump($url);

        $url = url('index/getParams', ['key1' => 1111, 'key2' => 222]);
        dump($url);
    }

    public function getParamsAction()
    {
        $params = $this->request->get();
        dump($params);
    }

    /**
     * [wxAction desc]
     * @desc 微信获取授权OPENID的测试
     * @composer require limingxinleo/wx-api
     * @author limx
     */
    public function wxAction()
    {
        $code = $this->request->get('code');
        $appid = env('APPID');
        $appsec = env('APPSECRET');
        $api = new OAuth($appid, $appsec);
        $api->code = $code;// 微信官方回调回来后 会携带code
        $url = env('APP_URL') . '/test/index/wx';//当前的URL
        $api->setRedirectUrl($url);
        $res = $api->getUserInfo();
        dump($res);
    }

    public function configAction()
    {
        dump(di('config')->env);
        dump($this->app['project-name']);
        dump(di('app'));
    }

    public function envAction()
    {
        dump(env('TEST'));
    }

    public function sessionAction()
    {
        $this->session->set("user-name", "Michael");
        $name = $this->session->get("user-name");
        dump($name);
        dump(session('user-name'));
    }

    public function addModelAction()
    {
        $user = new User();
        $user->name = time();
        $user->username = time();
        $user->password = time();
        $user->email = time();
        $user->role_id = 1;
        if ($user->save() === false) {
            foreach ($user->getMessages() as $v) {
                echo $v . "\n";
            }
        }
        dump($user->id);
    }

    public function editModelAction()
    {
        $user = User::findFirst(111);
        $user->name = time();
        $user->username = time();
//        $user->password = time();
        $user->email = time();
        $user->role_id = 1;
        if ($user->save() === false) {
            foreach ($user->getMessages() as $v) {
                echo $v . "\n";
            }
        }
        dump($user->id);
    }

    public function sqlAction()
    {
        $user = User::findFirst(1);
        dump($user->username);

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

