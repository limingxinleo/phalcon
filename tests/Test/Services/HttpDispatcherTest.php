<?php
// +----------------------------------------------------------------------
// | HttpDispatcherTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Services;

use \UnitTestCase;
use Phalcon\Mvc\Application;

/**
 * Class UnitTest
 */
class HttpDispatcherTest extends UnitTestCase
{
    protected $app;

    public function __construct()
    {
        $di = di();
        $this->app = new Application($di);
    }

    public function testGetControllerNameCase()
    {
        $service = di('dispatcher');
        $this->app->handle('/');
        $this->assertEquals('Index', ucfirst($service->getControllerName()));

        $this->app->handle('/error/show404');
        $this->assertEquals('Error', ucfirst($service->getControllerName()));
    }

    public function testSetControllerNameCase()
    {
        $service = di('dispatcher');
        $service->setControllerName('Index');
        $this->assertEquals('Index', ucfirst($service->getControllerName()));
    }

    public function testForwardCase()
    {
        $service = di('dispatcher');
        $service->forward([
            'namespace' => 'App\Controllers',
            "controller" => "Index",
            "action" => "index",
        ]);
        $this->assertEquals('Index', ucfirst($service->getControllerName()));
    }
}