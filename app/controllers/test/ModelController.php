<?php

namespace MyApp\Controllers\Test;

use MyApp\Models\User;

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

}

