<?php

require __DIR__ . '/src/Core/bootstrap.php';

use App\Aplication;
use Core\Router;

$router = new Router();
$aplication = new Aplication();

$aplication->start();