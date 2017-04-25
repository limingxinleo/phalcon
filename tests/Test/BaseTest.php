<?php
// +----------------------------------------------------------------------
// | 基础测试类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
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