<?php

namespace MyApp\Controllers;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
        echo '[' . __METHOD__ . ']';
    }

    public function testAction()
    {
        dump([1, 2, 3, 4]);
    }
}
