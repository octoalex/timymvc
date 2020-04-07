<?php
declare(strict_types=1);
define('ROOT', dirname(dirname(__FILE__)));


require '../src/autoload.php';

ini_set('display_errors', '1');
error_reporting(E_ALL);

use Core\App;

session_start();

$app = new App();
$app->run();

