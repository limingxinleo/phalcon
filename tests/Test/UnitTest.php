<?php
// +----------------------------------------------------------------------
// | UnitTest [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/26 Time: 16:46
// +----------------------------------------------------------------------
namespace Test;

use \UnitTestCase;

/**
 * Class UnitTest
 */
class UnitTest extends UnitTestCase
{
    public function testSessionCase()
    {
        $time = uniqid();
        session('test:case:session', $time);
        $this->assertEquals(
            $time,
            session('test:case:session')
        );
    }

    public function testCacheCase()
    {
        $data = [
            'time' => time(),
            'str' => uniqid()
        ];
        cache('test-case-cache', $data);
        $this->assertEquals(
            $data,
            cache('test-case-cache')
        );
    }
}