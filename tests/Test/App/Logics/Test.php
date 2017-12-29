<?php
// +----------------------------------------------------------------------
// | Test.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Tests\Test\App\Logics;

use Phalcon\Text;
use App\Core\Support\CacheBase;

class Test extends CacheBase
{
    /**
     * @desc   获取项目版本号
     * @author limx
     * @return mixed
     */
    public static function str()
    {
        return Text::random(Text::RANDOM_DISTINCT, 5);
    }
}
