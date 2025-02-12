<?php

namespace App\UseCase;

use App\Model\UserModel;

class UserUpdate
{
    private $id;
    private $name;
    private $email;
    private $cpf;
    private $nick;
    private $userModel;

    public function __construct($data)
    {
        $this->id = $data["id"] ?? null;
        $this->name = $data["name"] ?? null;
        $this->email = $data["email"] ?? null;
        $this->cpf = $data["cpf"] ?? null;
        $this->nick = $data["nick"] ?? null;
        $this->userModel = new UserModel();
    }

    public function update()
    {
        if (!$this->id) {
            return ["error" => "ID do usuário é obrigatório!"];
        }
        
        $existingUser = $this->userModel->findOneBy(["id" => $this->id]);
        if (!$existingUser) {
            return ["error" => "Usuário não encontrado!"];
        }
        
        $updateData = [
            "name" => $this->name ?? $existingUser["name"],
            "email" => $this->email ?? $existingUser["email"],
            "cpf" => $this->cpf ?? $existingUser["cpf"],
            "nick" => $this->nick ?? $existingUser["nick"],
            "date_updated" => date("Y-m-d H:i:s"),
        ];

        $updated = $this->userModel->updateById($this->id, $updateData);

        if (!$updated) {
            return ["error" => "Erro ao atualizar usuário!"];
        }

        return ["success" => "Usuário atualizado com sucesso!"];
    }
}
