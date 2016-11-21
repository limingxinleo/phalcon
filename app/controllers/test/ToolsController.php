<?php

namespace MyApp\Controllers\Test;

class ToolsController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

    }

    public function imgAction()
    {
        return $this->view->render('test/tools', 'img');
    }

}

