<?php

namespace MyApp\Controllers\Test;

class ApiController extends ControllerBase
{

    public function indexAction()
    {
        return $this->view->render('test/api', 'index');
    }

}

