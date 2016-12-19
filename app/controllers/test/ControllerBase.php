<?php

namespace MyApp\Controllers\Test;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $settings = [];

    public function initialize()
    {
        $this->settings = [
            "mySetting" => "value",
        ];
        if (strtolower($this->getName()) == strtolower('MyApp-Controllers-Test-index-qx2')) {
            if ($this->request->isPost()) {
                return error("返回错误");
            } else {
                return dispatch_error(500, "测试错误！");
            }
        }
    }

    public function getName()
    {
        $namespace = $this->router->getNamespaceName();
        $controller = $this->router->getControllerName();
        $action = $this->router->getActionName();

        $name = str_replace('\\', '-', $namespace);
        $name .= '-' . str_replace('\\', '-', $controller);
        $name .= '-' . str_replace('\\', '-', $action);

        return $name;
    }
}
