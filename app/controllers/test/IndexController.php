<?php

namespace MyApp\Controllers\Test;

use limx\tools\LRedis;
use limx\tools\MyRedis;
use limx\func\Match;
use limx\func\Str;
use limx\phalcon\DB;
use MyApp\Models\Test\User;
use limx\func\Curl;
use limx\tools\MyPDO;

class IndexController extends ControllerBase
{
    public function initAction()
    {
        dump($this->settings);
    }

    public function infoAction()
    {
        echo phpinfo();
    }

    public function pathAction()
    {
        $path = APP_PATH . '/../public/';
        dump($path);
        $path2 = dirname(APP_PATH) . '/public/';
        dump($path2);

    }

    public function qxAction()
    {
        return $this->view->render('test/index', 'qx');
    }

    public function qx1Action()
    {
        return success([1]);
    }

    public function qx2Action()
    {
        return success([1]);
    }

    public function prepareAction()
    {
        for ($i = 0; $i < 100; $i++) {
            $start = rand(1, 5);
            $end = rand(5, 10);

            $sql = "SELECT * FROM book WHERE uid > ? AND uid < ?;";
            $res = DB::query($sql, [$start, $end]);
            $count = count($res);
            dump($count);

            $sql = "SELECT * FROM book WHERE uid > {$start} AND uid < {$end};";
            $res = DB::query($sql);
            $count = count($res);
            dump($count);
        }

    }

    public function fetchAction()
    {
        $db = di('config');
        $config = [
            'type' => $db->database->adapter,
            'host' => $db->database->host,
            'dbname' => $db->database->dbname,
            'user' => $db->database->username,
            'pwd' => $db->database->password,
            'charset' => $db->database->charset,
        ];
        $pdo = MyPDO::getInstance($config);
        $sql = "SELECT * FROM user WHERE id > ? LIMIT 2";
        $res = $pdo->fetch($sql, [1]);
        dump($res);
        $res = $pdo->query($sql, [1]);
        dump($res);
    }

    public function dateAction()
    {
        dump(date('Y-m-d'));
        dump(strtotime(date('Y-m-d')));
        dump(time());
    }

    public function ipAction()
    {
        $url = 'http://api.eurekapi.com/iplocation/v1.8/locateip';
        $data = [
            'key' => env('IP_KEY'),
            'ip' => '220.181.57.217',
            'format' => 'JSON'
        ];
        $res = Curl::getArr($url, $data);
        dump($res);
    }

    public function zhuruAction()
    {
        /** pdo prepare 默认防止注入 */
        $id = $this->request->get('id');
        $sql = 'select * from user where id=?';
        $res = DB::query($sql, [$id]);
        dump($res);

        /** 也可防止注入 */
//        $res = User::findFirst($id);

        /** 字符串拼接不能有效防止注入 */
//        $sql = 'select * from user where id=' . $id;
//        $res = DB::query($sql);
//        dump($res);
    }

    public function wordAction()
    {
        $field = 'A';
        for ($i = 0; $i < 100; $i++) {
            dump($field++);
        }
    }

    public function vueAction()
    {
        return $this->view->render('test/index', 'vue');
    }

    public function pingbiAction()
    {
        $pb = [
            '卧槽', '尼玛', '我日'
        ];
        $str = '卧槽妈的尼玛de 啊啊啊啊我日';
        $res = Str::replace($pb, "*", $str);
        dump($res);
    }

    public function strAction()
    {
        dump(Str::ascii("我是天才"));
        dump(Str::ascii("Hello World"));

        dump(Str::camel("我是天才"));
        dump(Str::camel("Hello World"));

        dump(Str::contains("Hello World", ["SD"]));
        dump(Str::contains("我是天才", ["我"]));

        dump(Str::endsWith("Hello World", ["d"]));
        dump(Str::contains("我是天才", ["才"]));

        dump(Str::finish("Hello World", "d"));
        dump(Str::finish("我是天才", "才"));

        dump(Str::is("Hello*", "Hello World"));
        dump(Str::is("我*", "我是天才"));

        dump(Str::length("Hello World"));
        dump(Str::length("我是天才"));

        dump(Str::limit("Hello World", 8));
        dump(Str::limit("我是天才", 6));

        dump(Str::lower("Hello World"));
        dump(Str::lower("我是天才"));

        dump(Str::words("Hello World", 1));
        dump(Str::words("我是 天才", 2));

        dump(Str::quickRandom(2));
        dump(Str::quickRandom(12));

        dump(Str::equals('天才', '天才'));
        dump(Str::equals("asdf", 'asdff'));

        dump(Str::replaceFirst('天才', '我是', '我是天才我是天才'));
        dump(Str::replaceFirst("asdf", 'asdff', 'asdfxxxasdfxxx'));

        dump(Str::replaceLast('天才', '我是', '我是天才我是天才'));
        dump(Str::replaceLast("asdf", 'asdff', 'asdfxxxasdfxxx'));

        dump(Str::title('天才'));
        dump(Str::title("Hello World"));

        dump(Str::slug('天才'));
        dump(Str::slug("Hello World"));

        dump(Str::snake('天才'));
        dump(Str::snake("Hello World"));

        dump(Str::ucfirst('天才'));
        dump(Str::ucfirst("asdf"));

        dump(str_replace('天才', '我是', '我是天才我是天才'));
        dump(str_replace("asdf", 'asdff', 'asdfxxxasdfxxx'));

    }

    public function is_numericAction()
    {
        dump(is_numeric(1));
        dump(is_numeric('1'));
        dump(is_numeric("1"));
        dump(is_numeric(1.1));

        dump(Match::isInt(1));
        dump(Match::isInt('1'));
        dump(Match::isInt("1"));

        dump(Match::isInt("1.1"));
        dump(is_int(1.1));
        dump(is_int('1'));
    }

    public function uniqidAction()
    {
        dump(uniqid());
    }

    public function logAction()
    {
        logger("This is a Test Log Info");
        logger("This is a Test Log ERROR", 'error');
        logger("This is a Test Log Info In test", 'info', 'test.log');
        func();
    }

    public function pAction($key = 'p1', $p = 'p2')
    {
        dump($key);
        dump($p);
    }

    public function show500Action()
    {
        $code = '500';
        $msg = '出错了';
        return dispatch_error($code, $msg);
//        $dispatcher = di('dispatcher');
//        $dispatcher->forward(
//            [
//                'namespace' => 'MyApp\Controllers',
//                'controller' => 'error',
//                'action' => 'index',
//                'params' => [$code, $msg],
//            ]
//        );
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

        return $this->response->redirect('test/index/model');
    }


    public function cacheAction()
    {
        $config = di('config')->cache;
        dump($config);

        dump(di('cache')->get('test_1'));
        di('cache')->save('test_1', ['text' => 'Cache Test', 'time' => time()]);

        dump(di('cache')->queryKeys());

        cache('test_2', time());
        dump(cache('test_2'));

    }

    public function urlAction()
    {
        $url = $this->url->get('index/getParams', ['key1' => 1111, 'key2' => 222]);
        dump($url);

        $url = url('index/getParams', ['key1' => 1111, 'key2' => 222]);
        dump($url);

        $url = $this->request->getURI();
        dump($url);
        dump($this->request->getScheme() . ':' . $this->request->getHttpHost() . $url);

    }

    public function requestAction()
    {
        $request = $this->request;

        dump($request->get());                          //默认获取所有的请求参数返回的是array效果和获取$_REQUEST相同
        dump($request->get('wen'));                     //获取摸个特定请求参数key的valuer和$_REQUEST['key']相同
        dump($request->getQuery('url', null, 'url'));   //获取get请求参数,第二个参数为过滤类型,第三个参数为默认值
        dump($request->getMethod());                    //获取请求的类型如果是post请求会返回"POST"
        dump($request->isAjax());                       //判断请求是否为Ajax请求
        dump($request->isPost());                       //判断是否是Post请求类似的有(isGet,isPut,isPatch,isHead,isDelete,isOptions等)
        dump($request->getHeaders());                   //获取所有的Header,返回结果为数组
        dump($request->getHeader('Content-Type'));      //获取Header中的的莫一个指定key的指
        dump($request->getURI());                       //获取请求的URL比如phalcon.w-blog.cn/phalcon/Request获取的/phalcon/Request
        dump($request->getHttpHost());                  //获取请求服务器的host比如phalcon.w-blog.cn/phalcon/Request获取的phalcon.w-blog.cn
        dump($request->getServerAddress());             //获取当前服务器的IP地址
        dump($request->getRawBody());                   //获取Raw请求json字符
        dump($request->getJsonRawBody());               //获取Raw请求json字符并且转换成数组对象
        dump($request->getScheme());                    //获取请求是http请求还是https请求
        dump($request->getServer('REMOTE_ADDR'));       //等同于$_SERVER['REMOTE_ADDR']
    }

    public function getParamsAction()
    {
        $params = $this->request->get();
        dump($params);
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

    public function extAction()
    {
        dump(extension_loaded('pdo'));
        dump(extension_loaded('redis'));
        dump(extension_loaded('phalcon'));
        dump(extension_loaded('phalcon1'));
    }
}

