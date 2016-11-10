<?php

namespace MyApp\Controllers;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
        echo '[' . __METHOD__ . ']';
        return $this->view->render('users', 'index');
    }
}
