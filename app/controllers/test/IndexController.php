<?php

namespace MyApp\Controllers\Test;

use limx\tools\LRedis;
use limx\phalcon\DB;
use MyApp\Models\User;
use MyApp\Models\Book;
use limx\tools\wx\OAuth;
use limx\tools\MyRedis;

class IndexController extends ControllerBase
{
    public function initAction()
    {
        dump($this->settings);
    }

    public function indexAction()
    {
        return $this->view->render('test', 'index');
    }

    public function redisTestAction()
    {
        /** composer require limingxinleo/limx-redis */
        $config = [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'auth' => env('REDIS_AUTH'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_INDEX', 0),
        ];
        $redis = MyRedis::getInstance($config);
        dump($redis->keys('test:*'));
        $redis->set('test:1', 1);
        $redis->iNcr('test:2', 1);
        $redis->set('test:3', 1);

        $redis = LRedis::getInstance($config);
        $arr = $redis->keys('*');
        dump($arr);
        $redis->select(1);
        $arr = $redis->keys('*');
        dump($arr);
    }

    public function lredisAction()
    {
        /** composer require limingxinleo/limx-redis */
        $config = [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'auth' => env('REDIS_AUTH'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_INDEX', 0),
        ];
        $redis1 = LRedis::getInstance($config);
        $redis2 = LRedis::getInstance($config);
        dump($redis1);
        dump($redis2);
        $config['database'] = 1;
        $redis3 = LRedis::getInstance($config);
        dump($redis2);

        dump($redis1->keys('*'));
        dump($redis2->keys('*'));
        dump($redis3->keys('*'));
    }

    public function myredisAction()
    {
        $config = [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'auth' => env('REDIS_AUTH'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_INDEX', 0),
        ];
        $redis1 = MyRedis::getInstance($config);
        $redis2 = MyRedis::getInstance($config);
        dump($redis1);
        dump($redis2);
        $config['database'] = 1;
        $redis3 = MyRedis::getInstance($config);
        dump($redis2);

        dump($redis1->keys('*'));
        dump($redis2->keys('*'));
        dump($redis3->keys('*'));
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

        return $this->view->render('test/index', 'volt');
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

    public function hasManyAction()
    {
        $user = User::findFirst(1);
        foreach ($user->book as $v) {
            dump($v->name);
        }
    }


}

