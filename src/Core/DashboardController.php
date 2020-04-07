<?php

namespace Core;


use stdClass;

abstract class DashboardController
{
    /**
     * @var array
     */
    protected $params;
    /**
     * @var array
     */
    protected $query;
    /**
     * @var View
     */
    protected $view;

    /**
     * @var array|string
     */
    protected $body;
    /**
     * @var stdClass
     */
    protected $data;

    public function __construct()
    {
        Middleware::isAdmin();
        $this->data = new stdClass();
        $this->data->admin = Session::get('dashboard');
        $this->params = App::getParams();
        $this->body = App::getBody();
        $this->query = App::getQuery();
        $this->view = new View();
    }
}