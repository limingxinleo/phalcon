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
use limx\phalcon\Utils\Str;

/**
 * Class UnitTest
 */
class UnitTest extends UnitTestCase
{
    public function testSessionCase()
    {
        $value = uniqid();
        $key = 'test:case:session';
        $session = di('session');
        // 保存session
        $session->set($key, $value);
        // 是否存在session
        $this->assertTrue($session->has($key));
        // 获取session
        $this->assertEquals(
            $value,
            $session->get($key)
        );
        // 删除某个session
        $session->remove($key);
        $this->assertTrue(false === $session->has($key));
        // 销毁所有session
        // $session->destroy();
        // $this->assertTrue(false === $session->has($key), "会话销毁是相对于下次访问而言");
    }

    public function testCacheCase()
    {
        $data = [
            'time' => time(),
            'str' => Str::random(12),
        ];
        cache('test-case-cache', $data);
        $this->assertEquals(
            $data,
            cache('test-case-cache')
        );
    }
}