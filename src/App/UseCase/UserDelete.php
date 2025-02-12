<?php

namespace App\UseCase;

use App\Model\UserModel;

class UserDelete
{
    private $id;
    private $userModel;

    public function __construct($data)
    {
        $this->id = $data["id"] ?? null;
        $this->userModel = new UserModel();
    }

    public function delete()
    {
        if (!$this->id) {
            return ["error" => "ID do usuário é obrigatório!"];
        }
        
        $existingUser = $this->userModel->findOneBy(["id" => $this->id]);
        if (!$existingUser) {
            return ["error" => "Usuário não encontrado!"];
        }
        
        $deleted = $this->userModel->deleteById($this->id);

        if (!$deleted) {
            return ["error" => "Erro ao excluir o usuário!"];
        }

        return ["success" => "Usuário excluído com sucesso!"];
    }
}
