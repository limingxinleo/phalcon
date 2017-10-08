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

    /**
     * @desc   初始化
     * @author limx
     * @return mixed
     *
     * $this->add('name',new \Phalcon\Validation\Validator\PresenceOf([
     *     'message' => 'The name is required',
     * ]))
     */
    abstract public function initialize();

    /**
     * @desc   验证失败时获取错误信息
     * @author limx
     * @return string
     */
    public function getErrorMessage()
    {
        $msg = [];
        foreach ($this->getMessages() as $message) {
            $msg[] = $message->getMessage();
        }
        return implode(',', $msg);
    }

}