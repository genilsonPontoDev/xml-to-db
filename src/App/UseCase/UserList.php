<?php

namespace App\UseCase;

use App\Model\UserModel;

class UserList {

    public function __construct($data) {
        
    }
    
    public function list () {
        $userModel = new UserModel();
        $list = $userModel->getAll();        
        return $list;
    }    
}