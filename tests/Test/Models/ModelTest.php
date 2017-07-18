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
}