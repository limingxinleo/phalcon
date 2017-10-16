<?php

namespace App\Tasks;

use Phalcon\Cli\Dispatcher;

/**
 * Class Task
 * @package App\Tasks
 * @property Dispatcher $dispatcher
 */
abstract class Task extends \Phalcon\Cli\Task
{
    public $description;

    public function onConstruct()
    {
        /**
         * Phalcon\Cli\Task constructor
         *
         * public final function __construct()
         * {
         *     if method_exists(this, "onConstruct") {
         *         this->{"onConstruct"}();
         *     }
         * }
         */
    }

    public function beforeExecuteRoute()
    {
        // 在每一个找到的动作前执行
    }

    public function afterExecuteRoute()
    {
        // 在每一个找到的动作后执行
    }
}

