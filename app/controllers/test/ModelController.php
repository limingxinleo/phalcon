<?php

namespace MyApp\Controllers\Test;

use MyApp\Models\User;
use limx\phalcon\DB;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Paginator\Adapter\QueryBuilder;

class ModelController extends ControllerBase
{

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

}

