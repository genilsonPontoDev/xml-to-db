<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/src/Core/bootstrap.php';

use Core\Env;
Env::load();

use App\Aplication;
use Core\Router;

$router = new Router();
$aplication = new Aplication();

$aplication->start();
$router->build();
$aplication->index();