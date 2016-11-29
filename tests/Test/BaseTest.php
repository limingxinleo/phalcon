<?php
// +----------------------------------------------------------------------
// | 基础测试类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/26 Time: 20:26
// +----------------------------------------------------------------------
namespace Test;

use \UnitTestCase;

/**
 * Class UnitTest
 */
class BaseTest extends UnitTestCase
{
    public function testBaseCase()
    {
        $this->assertTrue(
            extension_loaded('phalcon')
        );
    }
}