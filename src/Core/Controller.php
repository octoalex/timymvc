<?php

namespace Core;


use stdClass;

abstract class Controller
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
        $this->data = new stdClass();
        $this->data->client = Session::get('client');
        $this->params = App::getParams();
        $this->body = App::getBody();
        $this->query = App::getQuery();
        $this->view = new View();
    }
}