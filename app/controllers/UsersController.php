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

        $this->session->set("user-name", "Michael");
        $name = $this->session->get("user-name");
        dump($name);
        dump(session('user-name'));
        
    }
}
