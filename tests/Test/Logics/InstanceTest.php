<?php
// +----------------------------------------------------------------------
// | CacheTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Logics;

use Test\App\Logics\Ins1;
use Test\App\Logics\Ins2;
use \UnitTestCase;

/**
 * Class UnitTest
 */
class InstanceTest extends UnitTestCase
{
    public function testBaseCase()
    {
        $this->assertEquals('Ins1', Ins1::getInstance()->str());
        $this->assertEquals('Ins2', Ins2::getInstance()->str());

        $ins1 = Ins1::getInstance();
        $this->assertEquals($ins1, Ins1::getInstance());
        $this->assertEquals($ins1, Ins1::getInstance()->instance());
    }
}