<?php

namespace MyApp\Controllers;

use Phalcon\Mvc\Controller;
use MyApp\Traits\System\Response;

class ControllerBase extends Controller
{
    use Response;

    public function initialize()
    {
    }
}
