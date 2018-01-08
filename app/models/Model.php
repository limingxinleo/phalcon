<?php
// +----------------------------------------------------------------------
// | Model基类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
namespace App\Models;

use Xin\Phalcon\Logger\Sys as LogSys;

/**
 * Class Model
 * @package App\Models
 * @method beforeCreate
 * @method beforeUpdate
 * @method afterSave
 */
abstract class Model extends \Phalcon\Mvc\Model
{

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        // 模型关系
        // $options=['alias' => 'user', 'reusable' => true] alias:别名 reusable:模型是否复用
        // $this->hasOne(...$params, $options = null)
        // $this->belongsTo(...$params, $options = null)
        // $this->hasMany(...$params, $options = null)
        // $this->hasManyToMany(...$params, $options = null)

        // Sets if a model must use dynamic update instead of the all-field update
        // $this->useDynamicUpdate(true);
    }

    /**
     * @desc   验证失败之后的事件
     * @author limx
     */
    public function onValidationFails()
    {
        $logger = di('logger')->getLogger('sql', LogSys::LOG_ADAPTER_FILE);
        $class = get_class($this);
        foreach ($this->getMessages() as $message) {
            $logger->error(sprintf("\n模型:%s\n错误信息:%s\n\n", $class, $message->getMessage()));
        }
    }
}
