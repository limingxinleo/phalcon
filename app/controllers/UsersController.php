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
        dump($this->app['project-name']);
    }
}
