<?php

use Core\Request;
use Core\Response;
use App\help\FactorRouterAll;

global $router;
global $model;

$router->post("/login", FactorRouterAll::add([
    "params" => [        
        ["email", "Informe o email"],
        ["password", "Informe a senha"],
    ],
    "message" => ["Não foi possível conectar!", "Login feito com sucesso!"],
    "case" => "App\UseCase\UserConnect",
    "validations" => [],
    "run" => "connect"
]));

$router->get("/valid", FactorRouterAll::add([
    "params" => [],
    "message" => ["Sessão inválida!", "Sessão válida!"],
    "case" => "App\UseCase\UserConnect",
    "validations" => [],
    "run" => "validateSession"
]));

$router->post("/pass/recover", FactorRouterAll::add([
    "params" => [        
        ["email", "Informe o email"],
    ],
    "message" => ["Erro ao tentar recuperar senha!", "E-mail de recuperação enviado com sucesso!"],
    "case" => "App\UseCase\UserConnect",
    "validations" => [],
    "run" => "recoveryPassword"
]));

$router->post("/pass/recover/sms", FactorRouterAll::add([
    "params" => [        
        ["phone", "Informe o telefone"],
    ],
    "message" => ["Erro ao tentar recuperar senha!", "Código de recuperação enviado com sucesso!"],
    "case" => "App\UseCase\UserConnect",
    "validations" => [],
    "run" => "recoveryPasswordPhone"
]));

$router->post("/pass/new", FactorRouterAll::add([
    "params" => [        
        ["email", "Informe o email"],
        ["code", "Informe o código recebido"],
        ["password", "Informe a nova senha"],
    ],
    "message" => ["Erro ao redefinir senha!", "Senha redefinida com sucesso!"],
    "case" => "App\UseCase\UserConnect",
    "validations" => [],
    "run" => "resetPassword"
]));

$router->get("/user/list", FactorRouterAll::add([
    "params" => [],
    "message" => ["Não foram encontrados usuários!", "Listado com sucesso!"],
    "case" => "App\UseCase\UserList",
    "validations" => [],
    "run" => "list"
]));


$router->get("/user/info", FactorRouterAll::add([
    "params" => [],
    "message" => ["Não foram encontrados usuarios!", "Listado com sucesso!"],
    "case" => "App\UseCase\UserList",
    "validations" => [],
    "run" => "userById"
]));

$router->post("/user/create", FactorRouterAll::add([
    "params" => [
        ["name", "informe o nome"],
        ["email", "informe o email"],
        ["password", "informe a senha"],
        ["cpf", "informe o cpf"],
        ["nick", "informe o nick"],
    ],
    "message" => ["Não foi possível criar usuário!", "Criado com sucesso!"],
    "case" => "App\UseCase\UserRegister",
    "validations" => [],
    "run" => "register"
]));

$router->post("/user/update", FactorRouterAll::add([
    "params" => [
        ["id", "Informe o ID do usuário"],
        ["name", "Informe o nome"],
        ["email", "Informe o email"],
        ["cpf", "Informe o CPF"],
        ["nick", "Informe o nick"],
    ],
    "message" => ["Não foi possível atualizar o usuário!", "Usuário atualizado com sucesso!"],
    "case" => "App\UseCase\UserUpdate",
    "validations" => [],
    "run" => "update"
]));

$router->post("/user/delete", FactorRouterAll::add([
    "params" => [
        ["id", "Informe o ID do usuário"],
    ],
    "message" => ["Erro ao tentar excluir o usuário!", "Usuário excluído com sucesso!"],
    "case" => "App\UseCase\UserDelete",
    "validations" => [],
    "run" => "delete"
]));


$router->get("/credentials/list", function () {});
$router->get("/credentials/info", function () {});
$router->post("/credentials/create", function () {});
$router->post("/credentials/update", function () {});
$router->post("/credentials/delete", function () {});


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
