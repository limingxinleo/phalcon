<?php
// +----------------------------------------------------------------------
// | Validator.php [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Validation;

use Phalcon\Validation;

abstract class Validator extends Validation
{

    abstract public function initialize();

    public function getErrorMessage()
    {
        $msg = [];
        foreach ($this->getMessages() as $message) {
            $msg[] = $message->getMessage();
        }
        return implode(',', $msg);
    }

}