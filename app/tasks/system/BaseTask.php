<?php
// +----------------------------------------------------------------------
// | 脚本基类 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2017/3/6 Time: 下午12:59
// +----------------------------------------------------------------------
namespace MyApp\Tasks\System;

use Phalcon\Cli\Task;
use limx\phalcon\Cli\Color;
use Phalcon\Annotations\Adapter\Memory as Annotation;

/**
 * @BaseTask
 * @package MyApp\Tasks\System
 */
class BaseTask extends Task
{
    public function helpAction()
    {
        echo $this->dispatcher->getNamespaceName();
        $reader = new Annotation();
        // 反射在Example类的注释
        $reflector = $reader->get("MyApp\\Tasks\\System\\BaseTask");

        // 读取类中注释块中的注释
        $annotations = $reflector->getClassAnnotations();

        // 遍历注释
        foreach ($annotations as $annotation) {
            // 打印注释名称
            echo $annotation->getName(), PHP_EOL;

            // 打印注释参数个数
            echo $annotation->numberArguments(), PHP_EOL;

            // 打印注释参数
            print_r($annotation->getArguments());
        }
    }
}