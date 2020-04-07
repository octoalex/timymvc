<?php


namespace Controllers;

use Core\App;
use Core\Controller;
use Core\Image;
use Core\Middleware;
use Core\Session;
use Models\Client;

class Clients extends Controller
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

    public function cabinet()
    {
        Middleware::isLoginClient();
        $this->data->client = $this->model->getClientById(Session::get('client')['id']);
        $this->view->render('clients/cabinet', (array)$this->data);
    }
    public function logout(){
        Session::set('client','');
        App::redirect('/');
    }

    public function register()
    {
        if (Session::get('client') !== '')
            App::redirect('/');
        if (App::getMethod() === 'POST') {
            $this->body['image'] = '';
            if (App::getFiles() && isset(App::getFiles()['photo'])) {
                $photo = App::getFiles()['photo'];
                if ($photo['error'] !== 0) {
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
            $check = $this->model->registerClient($this->body);
            if ($check['status']) {
                App::redirect('/');
            } else {
                $this->data->errors = $check['errors'];
                $this->view->render('clients/register', (array)$this->data);
            }
        } else {
            $this->view->render('clients/register', (array)$this->data);
        }


    }

    public function checkLoginExist()
    {
        if (isset($this->params[0]) && $this->params[0] !== '') {
            $result = $this->model->checkLoginExist($this->params[0]);
            if ($result) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        } else {
            header("Location: /");
        }

    }

    public function checkEmailExist()
    {
        if (App::getMethod() === 'POST') {
            $result = $this->model->checkEmailExist($this->body['data']);
            if ($result) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        } else {
            header("Location: /");
        }

    }


    public function login()
    {
        if (App::getMethod() === 'POST') {
            $client = $this->model->getClient($this->body['login'], $this->body['password']);
            if ($client) {
                Session::set('client', $client);
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        } else {
            header("Location: /");
        }


    }


}