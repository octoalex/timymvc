<?php

use Core\App;

spl_autoload_register(function ($class) {
    $fileName = dirname(__FILE__) . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($fileName)) {
        require_once $fileName;
    } else {
        App::error404();
    }

});
