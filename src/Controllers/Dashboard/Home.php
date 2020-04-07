<?php


namespace Controllers\Dashboard;


use Core\DashboardController;

class Home extends DashboardController
{
    public function index()
    {
        $this->view->render('admin/home/index', (array)$this->data, true);

    }



}