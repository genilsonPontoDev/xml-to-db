<?php

use Core\Request;
use Core\Response;

global $router;
global $model;


$router->get("/", function (Request $req, Response $res) use ($model)  {
    $res->status(200)->body(['success' => 'Sucesso!']);
});