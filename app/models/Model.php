<?php
// +----------------------------------------------------------------------
// | Model基类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace App\Models;

abstract class Model extends \Phalcon\Mvc\Model
{

    /**
     * Initialize method for model.
     */
    public function initialize()
    {

    }

    /**
     * @desc   只修改某些字段的更新方法
     * @author limx
     * @param      $data
     * @param null $whiteList
     * @return bool
     */
    public function updateOnly($data, $whiteList = null)
    {
        $attributes = $this->getModelsMetaData()->getAttributes($this);
        $this->skipAttributesOnUpdate(array_diff($attributes, array_keys($data)));

        return parent::update($data, $whiteList);
    }

    public static function __callStatic($method, $arguments)
    {
        parent::__callStatic($method, $arguments);
    }

    public function beforeCreate()
    {
        // 数据创建之前
    }

    public function beforeUpdate()
    {
        // 数据更新之前
    }

    public function afterSave()
    {
        // 数据修改之后
    }

}
