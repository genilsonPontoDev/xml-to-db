<?php

namespace App\Model;

use App\DTO\DtoEmitente;
use Core\Model;

class Emitente extends Model
{
    public $table = 'usuario_nota';
    public $ID;
    public $xml;
    public $dto;
    
    public function __construct(DtoEmitente $emitente) {
        parent::__construct();        
        $this->dto = $emitente;        
    }

    function save (): DtoEmitente { 
        $exists = $this->exists();
        //var_dump('teste');die();       
        if ($exists) {
            //$this->update('Usuarios',$this->dto);
            var_dump('atualiza');
            $this->update($this->table, ['xNome' => $this->dto->name], 'id_usuario = :ID', [':ID' => $this->dto->ID]);
        } else {
            var_dump('insere');
            $this->insert($this->table,['xNome' => $this->dto->name]);
        }

        return $this->dto;
    }

    function exists (): bool {        
        return count($this->select($this->table, 'id_usuario = :ID',[':ID' => $this->dto->ID])) > 0;
    }
}
