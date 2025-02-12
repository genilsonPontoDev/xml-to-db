<?php

namespace App\UseCase;

use App\Model\UserModel;
use App\Service\SmsService;

class UserConnect {
    
    public $params;

    public function __construct($data) {
        $this->params = $data;
    }
    
    public function connect() {
        $userModel = new UserModel();
        $user = $userModel->authenticate($this->params);
        
        if ($user) {
            return ['success' => true, 'message' => 'Usuário autenticado com sucesso', 'user' => $user];
        } else {
            return ['success' => false, 'message' => 'Falha na autenticação'];
        }
    }    

    public function recoveryPassword() {
        $userModel = new UserModel();
        $result = $userModel->resetPassword($this->params);

        if ($result) {
            return ['success' => true, 'message' => 'E-mail de recuperação enviado com sucesso'];
        } else {
            return ['success' => false, 'message' => 'Erro ao tentar recuperar senha'];
        }
    }  

    public function recoveryPasswordPhone() {
        $userModel = new UserModel();
        $smsService = new SmsService();
        
        if (!isset($this->params['phone']) || empty($this->params['phone'])) {
            return ['success' => false, 'message' => 'Telefone não informado'];
        }

        $phone = $this->params['phone'];
                $code = rand(100000, 999999); 
        
        $saved = $userModel->saveRecoveryCode($phone, $code);
        
        if (!$saved) {
            return ['success' => false, 'message' => 'Erro ao gerar código de recuperação'];
        }
        
        $smsSent = $smsService->sendSms($phone, "Seu código de recuperação é: $code");

        if ($smsSent) {
            return ['success' => true, 'message' => 'Código de recuperação enviado com sucesso!'];
        } else {
            return ['success' => false, 'message' => 'Erro ao enviar o código de recuperação'];
        }
    }
}
