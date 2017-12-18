<?php
// +----------------------------------------------------------------------
// | CacheTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\Logics;

use Tests\Test\App\Logics\Test;
use Tests\UnitTestCase;

/**
 * Class UnitTest
 */
class CacheTest extends UnitTestCase
{
    public function testBaseCase()
    {
        $this->assertTrue(Test::str() !== Test::str());
        $this->assertTrue(Test::strFromCache() === Test::strFromCache());
    }
}