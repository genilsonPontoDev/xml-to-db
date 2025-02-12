<?php

namespace App\UseCase;

use App\Model\UserModel;

class UserList {
    
    public $params;

    public function __construct($data) {
        $this->params = $data;
    }
    
    public function list () {
        $userModel = new UserModel();
        $list = $userModel->getAll();        
        return $list;
    }    

    public function userById () {        
        $userModel = new UserModel();
        $list = $userModel->findOneBy($this->params);        
        return $list;
    }    
}