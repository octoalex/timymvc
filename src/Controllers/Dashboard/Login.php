<?php


namespace Controllers\Dashboard;


use Core\App;
use Core\Config;
use Core\Controller;
use Core\Session;

class Login extends Controller
{
    public function index(){
        if(App::getMethod() === 'POST'){
            $credentials = Config::get('dashboard');
            if ($this->body['login'] === $credentials['login'] && md5($this->body['password']) === $credentials['password']){
                Session::set('dashboard',['name'=>$credentials['login'],'email'=>$credentials['email']]);
                App::redirect('/dashboard');
            }else{
                $this->view->render('admin/login/index', (array)$this->data,true);
            }

        }
        $this->view->render('admin/login/index', (array)$this->data,true);
    }

}