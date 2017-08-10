<?php
// +----------------------------------------------------------------------
// | ConfigTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Services;

use App\Logics\System;
use \UnitTestCase;

/**
 * Class UnitTest
 */
class ConfigTest extends UnitTestCase
{
    public function testAppCase()
    {
        $project = app('project-name');
        $this->assertEquals('limx-phalcon-project', $project);
    }

    public function testAppGetCase()
    {
        $project = di('app')->get('project-name');
        $this->assertEquals('limx-phalcon-project', $project);
    }

    public function testAppGetDotCase()
    {
        $err = app('error-code.500');
        $this->assertEquals('服务器错误！', $err);
    }

    public function testConfigCase()
    {
        $version = di('config')->get('version');
        $this->assertEquals((new System())->version(), $version);
    }
}