<?php

namespace MyApp\Controllers\Admin;

class UsersController extends ControllerBase
{

    public function indexAction()
    {
        echo '[' . __METHOD__ . ']';
        return $this->view->render('admin/users','index');
    }
}
