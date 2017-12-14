<?php
// +----------------------------------------------------------------------
// | HttpTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test;

use \UnitTestCase;
use Phalcon\Mvc\Application;
use App\Core\System;

/**
 * Class UnitTest
 */
class HttpTest extends UnitTestCase
{
    protected $application;

    public function __construct()
    {
        $di = di();
        $this->application = new Application($di);
        // $this->application->useImplicitView(false);
    }

    public function testJsonResponseCase()
    {
        $_SERVER['REQUEST_METHOD'] = "POST";
        $response = $this->application->handle("/index/index");
        $data = $response->getContent();
        $data = json_decode($data);
        $this->assertEquals(System::getInstance()->version(), $data->version);
        $this->assertEquals("You're now flying with Phalcon. Great things are about to happen!", $data->message);
    }
}