<?php
// +----------------------------------------------------------------------
// | Collections.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Models;

use Test\App\Models\Collections\User;
use \UnitTestCase;

/**
 * Class UnitTest
 */
class CollectionsTest extends UnitTestCase
{
    public function testBaseCase()
    {
        if (di('config')->mongo->isCollection) {
            $user = new User();
            $user->id = 2;
            $user->name = '测试';
            $user->save();

            $users = User::find([
                'conditions' => ['id' => 2]
            ]);

            $this->assertTrue(count($users) > 0);
        }

    }
}