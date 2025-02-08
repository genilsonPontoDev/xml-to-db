<?php

use Core\Request;
use Core\Response;
use App\help\FactorRouterAll;

global $router;
global $model;

$router->post("/login", function() {});
$router->get("/valid", function() {});
$router->post("/pass/recover", function() {});
$router->post("/pass/new", function() {});

$router->get("/user/list", FactorRouterAll::add([
    "params" => [],
    "message" => ["Não foram encontrados usuarios!", "Listado com sucesso!"],
    "case" => "App\UseCase\UserList",
    "validations" => [],
    "run" => "list"
]));

$router->get("/user/info", function() {
    echo "qualquer";
});

$router->post("/user/create", FactorRouterAll::add([
    "params" => [
        ["nome", "informe o nome"],
    ],
    "message" => ["Não foi possível criar usuário!", "Criado com sucesso!"],
    "case" => "App\UseCase\UserRegister",
    "validations" => [],
    "run" => "register"
]));

$router->post("/user/update", function() {});
$router->post("/user/delete", function() {});

$router->get("/credentials/list", function() {});
$router->get("/credentials/info", function() {});
$router->post("/credentials/create", function() {});
$router->post("/credentials/update", function() {});
$router->post("/credentials/delete", function() {});




$router->post("/api/v1/user/company/update", FactorRouterAll::add([
    "params" => [
        ['client_public_id', "informe um identificador de usuário"],
        ['company_type_id', "informe um tipo de empresa"],
    ],
    "case" => "App\UseCase\CompanyUpdate",
    "message" => ["Erro ao atualizar tipo de empresa", "Tipo de empresa atualizado com sucesso"],
    "validations" => [
        ["isClient", "Cliente não existe"],
    ],
    "run" => "execute"
]));