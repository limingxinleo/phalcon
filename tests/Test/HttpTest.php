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
        $status = 0;
        $message = "test";
        $response = $this->application->handle(sprintf("/error/json/%d/%s", $status, $message));
        $data = $response->getContent();
        $data = json_decode($data);
        $this->assertEquals($status, $data->status);
        $this->assertEquals($message, $data->message);
    }
}