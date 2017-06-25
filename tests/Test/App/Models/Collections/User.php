<?php
// +----------------------------------------------------------------------
// | User.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace Test\App\Models\Collections;

use App\Models\Collections\Mongo;

class User extends Mongo
{
    public $id;

    public $name;

    /**
     * Returns collection name mapped in the model
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }
}