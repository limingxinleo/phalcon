<?php
// +----------------------------------------------------------------------
// | UrlTest.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\Services;

use \UnitTestCase;

/**
 * Class UnitTest
 */
class UrlTest extends UnitTestCase
{
    public function testGetCase()
    {
        $service = di('url');

        $service->setBaseUri('/');
        $url = $service->get('index', ['key' => 'val']);
        $this->assertEquals('/index?key=val', $url);

        $service->setBaseUri('/test/');
        $url = $service->get('index', ['key' => 'val']);
        $this->assertEquals('/test/index?key=val', $url);

    }

    public function testGetStaticCase()
    {
        $service = di('url');

        $service->setStaticBaseUri('/');
        $url = $service->getStatic('static/images/avatar.png');
        $this->assertEquals('/static/images/avatar.png', $url);

        $service->setStaticBaseUri('/test/');
        $url = $service->getStatic('static/images/avatar.png');
        $this->assertEquals('/test/static/images/avatar.png', $url);
    }
}