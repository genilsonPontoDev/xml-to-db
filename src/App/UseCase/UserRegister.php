<?php

namespace App\UseCase;

use App\Model\UserModel;

class UserRegister
{
    public $name;
    public $email;
    public $password;
    public $cpf;
    public $nick;
    public $rule_id;
    public $status;
    public $code;

    public function __construct($data)
    {        
        $this->name = $data["name"] ?? null;
        $this->email = $data["email"] ?? null;
        $this->password = $data["password"] ?? null;
        $this->cpf = $data["cpf"] ?? null;
        $this->nick = $data["nick"] ?? "";
        $this->rule_id = $data["rule_id"] ?? null;
        $this->status = $data["status"] ?? null;
        $this->code = $data["code"] ?? null;
    }

    public function register()
    {        
        $user = new UserModel(); 
        $today = date("Y-m-d H:i:s");         
        $user->create([
            "name" => $this->name,
            "email" => $this->email,
            "password" => $this->password,
            "cpf" => $this->cpf,
            "nick" => $this->nick,
            "rule_id" => $this->rule_id,
            "status" => $this->status,
            "code" => $this->code,
            "date_created" => $today,
            "date_updated" => $today
        ]);
        return [];
    }
}