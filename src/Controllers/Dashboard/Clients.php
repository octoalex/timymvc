<?php


namespace Controllers\Dashboard;


use Core\App;
use Core\Config;
use Core\DashboardController;
use Core\Image;
use Models\Client;

class Clients extends DashboardController
{
    /**
     * @var Client
     */
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Client();
    }

    public function index()
    {
        $limit = Config::get('dashboard.user_paginate');
        $count = $this->model->getClientsCount();
        $page = isset($this->query['page']) ? intval(htmlentities($this->query['page'][0], ENT_QUOTES)) : 0;
        if ($page !== 0) {
            $this->data->clients = $this->model->getForDashboard($limit, $page);
            $this->data->pages = (int)ceil($count / $limit);
            $this->data->current_page = $page;
            $this->data->club_state = Config::get('defaults.club_user');
            if ($this->data->current_page > $this->data->pages) {
                App::redirect('/dashboard/clients?page=1');
            }
        } else {
            if ($count > $limit) {
                App::redirect('/dashboard/clients?page=1');
            }
            $this->data->clients = $this->model->getForDashboard();
        }
        $this->view->render('admin/clients/index', (array)$this->data, true);

    }

    public function show()
    {
        $id = isset($this->params[0]) ? intval(htmlentities($this->params[0], ENT_QUOTES)) : null;
        if (!$id) {
            App::redirect('/dashboard');
        }
        $client = $this->model->getClientById($id);
        if (!$client)
            App::error404();
        $this->data->client = $client;
        $this->data->club_state = Config::get('defaults.club_user');
        $this->view->render('admin/clients/show', (array)$this->data, true);

    }

    public function create()
    {
        if (App::getMethod() === 'POST') {
            $this->body['image'] = '';
            if (App::getFiles() && isset(App::getFiles()['photo'])) {
                $photo = App::getFiles()['photo'];
                if ($photo['error'] === 0) {
                    $image = new Image($photo);
                    $image->load();
                    if ($image->getWidth() > 900) {
                        $image->resizeToWidth(900);
                    }
                    $image->save();
                    $image->saveThumb();
                    $this->body['image'] = $image->getFileName();
                }
            }
            $check = $this->model->registerAdminClient($this->body);
            if ($check['status']) {
                App::redirect('/dashboard/clients/');
            } else {
                $this->data->errors = $check['errors'];
                $this->data->club_state = Config::get('defaults.club_user');
                $this->view->render('admin/clients/create', (array)$this->data, true);
            }
        } else {
            $this->data->club_state = Config::get('defaults.club_user');
            $this->view->render('admin/clients/create', (array)$this->data, true);
        }


    }


    public function edit()
    {
        $id = isset($this->params[0]) ? intval(htmlentities($this->params[0], ENT_QUOTES)) : null;
        if (!$id) {
            App::redirect('/dashboard');
        }
        if (App::getMethod() === 'POST') {
            if (App::getFiles() && isset(App::getFiles()['photo'])) {
                $photo = App::getFiles()['photo'];
                if ($photo['error'] === 0) {
                    $image = new Image($photo);
                    $image->load();
                    if ($image->getWidth() > 900) {
                        $image->resizeToWidth(900);
                    }
                    $image->save();
                    $image->saveThumb();
                    $this->body['image'] = $image->getFileName();
                }
            }
            $check = $this->model->updateClient($this->body, $id);
            if ($check['status']) {
                App::redirect('/dashboard/clients/');
            } else {
                $this->data->errors = $check['errors'];
                $client = $this->model->getClientById($id);
                if (!$client)
                    App::error404();
                $this->data->client = $client;
                $this->data->club_state = Config::get('defaults.club_user');
                $this->view->render('admin/clients/edit', (array)$this->data, true);
            }
        } else {
            $client = $this->model->getClientById($id);
            if (!$client)
                App::error404();
            $this->data->client = $client;
            $this->data->club_state = Config::get('defaults.club_user');
            $this->view->render('admin/clients/edit', (array)$this->data, true);
        }


    }

    public function delete()
    {
        $id = isset($this->params[0]) ? intval(htmlentities($this->params[0], ENT_QUOTES)) : null;
        if (!$id) {
            App::redirect('/dashboard');
        }
        if (App::getMethod() === 'POST') {
            $this->model->deleteById($id);
            App::redirect('/dashboard/clients/');
        }

        $this->view->render('admin/clients/delete', (array)$this->data, true);


    }

}