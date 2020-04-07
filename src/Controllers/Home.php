<?php


namespace Controllers;

use Core\Config;
use Core\Controller;

class Home extends Controller
{

    public function index()
    {
        $this->view->render('home/index', (array)$this->data);
    }


}