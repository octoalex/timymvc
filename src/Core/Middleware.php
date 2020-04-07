<?php


namespace Core;


class Middleware
{
    public static function isLoginClient(){
        if (Session::get('client') === '')
            App::redirect('/');
    }


    public static function isAdmin(){
        if (Session::get('dashboard') === '')
            App::redirect('/dashboard/login');
    }




}