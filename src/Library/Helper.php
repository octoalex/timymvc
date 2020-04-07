<?php
namespace Library;


use Core\Session;

class Helper
{
    public static function dnd($msg) : void
    {
        echo '<pre>';
        print_r($msg);
        echo '</pre>';
        exit();
    }

}