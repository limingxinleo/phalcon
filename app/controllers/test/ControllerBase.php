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
    }
}
