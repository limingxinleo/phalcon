<?php

namespace MyApp\Controllers\Admin;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        echo '[' . __METHOD__ . ']';
        return $this->view->render('admin/index', 'index');
    }
}
