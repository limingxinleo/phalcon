<?php
// +----------------------------------------------------------------------
// | ModelTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Models;

use Test\App\Models\User;
use \UnitTestCase;

/**
 * Class UnitTest
 */
class ModelTest extends UnitTestCase
{
    public function testBaseCase()
    {
        $username = uniqid();
        $user = new User();
        $user->username = $username;
        $user->email = 'test@test.com';
        $user->role_id = 1;
        $user->password = md5('123456');
        $res = $user->save();
        $this->assertTrue($res);

        $count = User::count();
        $this->assertTrue($count > 0);

        $last_user = User::findFirst([
            'order' => 'id DESC',
        ]);
        $this->assertEquals($username, $last_user->username);
        $this->assertTrue(isset($last_user->updated_at));
        $this->assertTrue(isset($last_user->created_at));

    }

    public function testSaveFailCase()
    {
        $username = 'fail' . uniqid();

        $user = new User();
        $user->username = $username;
        $user->password = md5('123456');
        $this->assertFalse($user->save());
    }

    public function testModelsManagerCase()
    {
        $di = di();
        $this->assertTrue(
            $di->has('modelsManager'),
            'No ModelsManager Service'
        );
    }

    public function testBuilderCase()
    {
        $manager = di('modelsManager');
        $user = User::class;

        $query = $manager->createQuery("SELECT * FROM {$user} ORDER BY id DESC LIMIT 1");
        $users = $query->execute();
        $this->assertTrue($users[0]->id > 0);

        $users = $manager->createBuilder()
            ->from($user)
            ->where('id=1')
            ->getQuery()
            ->execute();

        $this->assertTrue($users[0]->id > 0);
        $this->assertTrue(count($users) === 1);

        // $res = $manager->createBuilder()
        //     ->from($user)
        //     ->where('id', 1)
    }

    public function testUpdateOnlyCase()
    {
        $last_user = User::findFirst([
            'order' => 'id DESC',
        ]);
        $name = $last_user->name;

        $username = uniqid();
        $last_user->name = uniqid(); // 不生效

        $res = $last_user->updateOnly(['username' => $username]);
        $this->assertTrue($res);

        $user = User::findFirst([
            'order' => 'id DESC',
        ]);
        $this->assertEquals($user->username, $username);
        $this->assertEquals($user->name, $name);

    }
}