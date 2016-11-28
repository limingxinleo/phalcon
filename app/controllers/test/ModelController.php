<?php

namespace MyApp\Controllers\Test;

use MyApp\Models\Test\Role;
use MyApp\Models\Test\Title;
use MyApp\Models\Test\User;
use MyApp\Models\Test\Book;
use MyApp\Models\Test\UserTitle;

use limx\phalcon\DB;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\QueryBuilder;
use limx\tools\MyPDO;

class ModelController extends ControllerBase
{

    public function initAction()
    {
        /** 增加一个角色 */
        $role = new Role();
        $role->name = "角色" . rand(0, 10);
        $res[] = $role->save();

        /** 增加5个用户 */
        $roles = $role->find([
            'columns' => 'id'
        ]);
        $count = count($roles);
        for ($i = 0; $i < 5; $i++) {
            $id = rand(0, $count - 1);
            $user = new User();
            $user->username = 'user' . time() . rand(0, 10000);
            $user->password = md5('910123');
            $user->name = '用户' . rand(0, 10000);
            $user->role_id = $roles[$id]['id'];
            if ($user->save() === true) {
                $res[] = $user->save();
            } else {
                $error = '';
                foreach ($user->getMessages() as $v) {
                    $error .= $v . '';
                }
                $res[] = $error;
            }
        }

        /** 增加50本书 */
        $users = $user->find([
            'columns' => 'id'
        ]);
        $count = count($users);
        for ($i = 0; $i < 50; $i++) {
            $id = rand(0, $count - 1);
            $user = new Book();
            $user->uid = $users[$id]['id'];
            $user->name = '书' . rand(0, 10000);
            if ($user->save() === true) {
                $res[] = true;
            } else {
                $error = '';
                foreach ($user->getMessages() as $v) {
                    $error .= $v . '';
                }
                $res[] = $error;
            }
        }

        /** 增加10个 称号 */
        for ($i = 0; $i < 10; $i++) {
            $title = new Title();
            $title->name = "称号" . rand(0, 1000);
            $res[] = $title->save();
        }

        /** 给所有用户增加一个称号 */
        $titles = Title::find([
            'columns' => 'id'
        ]);
        $len = count($titles);
        for ($i = 0; $i < $count; $i++) {
            $id = rand(0, $count - 1);
            $id2 = rand(0, $len - 1);
            $ut = new UserTitle();
            $ut->uid = $users[$id]['id'];
            $ut->title_id = $titles[$id2]['id'];
            if ($ut->save() === true) {
                $res[] = true;
            } else {
                $error = '';
                foreach ($ut->getMessages() as $v) {
                    $error .= $v . '';
                }
                $res[] = $error;
            }
        }

        dump($res);
    }

    public function indexAction()
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

    public function addAction()
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

    public function editAction()
    {
        $user = User::findFirst(1);
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

    /**
     * [hasManyAction desc]
     * @desc 模型中增加下面初始化
     * public function initialize()
     * {
     *     $this->hasMany("id", "MyApp\\Models\\Book", "uid", ['alias' => 'book']);
     * }
     * @author limx
     */
    public function hasManyAction()
    {
        $user = User::findFirst(1);
        foreach ($user->book as $v) {
            dump($v->name);
        }
    }

    public function belongsToAction()
    {
        $id = rand(1, 100);
        dump($id);
        $book = Book::findFirst($id);
        if (empty($book)) {
            dump("书本不存在");
            return;
        }
        dump($book->user->name);
    }

    public function hasManyToManyAction()
    {
        $id = rand(0, 10);
        dump($id);
        $user = User::findFirst($id);
        if (empty($user)) {
            dump("用户不存在");
            return;
        }
        foreach ($user->title as $v) {
            dump($v->name);
        }
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

    /**
     * [pageAction desc]
     * @desc 默认的分页为全表查询，效率 低！！！
     * @author limx
     */
    public function pageAction()
    {
        // Current page to show
        // In a controller/component this can be:
        // $this->request->getQuery("page", "int"); // GET
        // $this->request->getPost("page", "int"); // POST
        $currentPage = $this->request->get('page');

        // The data set to paginate
        $users = User::find();

        // Create a Model paginator, show 10 rows by page starting from $currentPage
        $paginator = new PaginatorModel(
            [
                "data" => $users,
                "limit" => 5,
                "page" => $currentPage,
            ]
        );

        // Get the paginated results
        $page = $paginator->getPaginate();
        $this->view->setVar('page', $page);
        $this->view->render('test/index', 'page');
    }

    public function page2Action()
    {
        $page = $this->request->get('page');
        $sql = "SELECT * FROM `user` LIMIT 10 OFFSET ?;";
        $res = DB::query($sql, [$page]);
        $count = DB::fetch("SELECT COUNT(0) as num FROM `user`;");
        dump($res);
        dump($count['num']);
    }

    public function page3Action()
    {
        $page = $this->request->get('page');
        $builder = $this->modelsManager->createBuilder()
            ->columns('id, name')
            ->from('MyApp\Models\User')
            ->orderBy('name');

        $paginator = new QueryBuilder(
            [
                'builder' => $builder,
                'limit' => 20,
                'page' => $page,
            ]
        );
        // Get the paginated results
        $page = $paginator->getPaginate();
        $this->view->setVar('page', $page);
        $this->view->render('test/index', 'page');
    }

    /**
     * [transAction desc]
     * @desc 事务操作，当我们在一个事务内修改了数据的时候，
     * 其他客户端查询到的数据是没有被修改的。知道事务被提交。
     * @author limx
     */
    public function transAction()
    {
        /** @var composer require limingxinleo/limx-pdo */
        $config = [
            'type' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => env('DB_DBNAME'),
            'user' => env('DB_USERNAME'),
            'pwd' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ];
        $mysql = MyPDO::getInstance($config);

        DB::begin();
        $sql = "SELECT * FROM user WHERE id=?";
        $sql2 = "UPDATE user SET name=? WHERE id=?";
        $res = DB::fetch($sql, [1]);
        dump("原始数据：" . $res['name']);
        DB::execute($sql2, [time(), 1]);
        $res = DB::fetch($sql, [1]);
        dump("本事务内修改：" . $res['name']);
        $res = $mysql->query($sql, [1]);
        dump("事务内其他链接 修改：" . $res[0]['name']);
        DB::rollback();
//        DB::commit();
        $res = DB::fetch($sql, [1]);
        dump("事务结束后数据：" . $res['name']);


    }

}

