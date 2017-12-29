<?php
// +----------------------------------------------------------------------
// | View 服务 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 limingxinleo All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <https://github.com/limingxinleo>
// +----------------------------------------------------------------------
namespace App\Core\Services\Mvc;

use App\Core\Services\ServiceProviderInterface;
use Phalcon\Config;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class View implements ServiceProviderInterface
{
    public function register(FactoryDefault $di, Config $config)
    {
        /**
         * Setting up the view component
         */
        $di->setShared('view', function () use ($config) {
            $view = new \Phalcon\Mvc\View();

            $view->setViewsDir($config->application->viewsDir);

            $view->registerEngines(
                [
                    '.volt' => function ($view, $di) use ($config) {
                        $volt = new VoltEngine($view, $di);

                        $volt->setOptions(
                            [
                                'compiledPath' => $config->application->cacheDir . 'view/',
                                'compiledSeparator' => '_'
                            ]
                        );

                        return $volt;
                    },
                    // Generate Template files uses PHP itself as the template engine
                    '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
                ]
            );

            return $view;
        });
    }
}
