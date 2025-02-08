<?php

namespace App\Model;

use App\DTO\DtoEmitente;
use Core\Model;

class Emitente extends Model
{
    public $table = 'emitente'; // Alterado de usuario_nota para emitente
    public $dto;

    public function __construct(DtoEmitente $emitente)
    {
        parent::__construct();
        $this->dto = $emitente;
    }

    public function save(): DtoEmitente
    {
        $exists = $this->exists();

        $data = [
            'nome'       => $this->dto->nome,
            'cnpj'       => $this->dto->cnpj,
            'logradouro' => $this->dto->logradouro,
            'numero'     => $this->dto->numero,
            'bairro'     => $this->dto->bairro,
            'cidade'     => $this->dto->nomeMunicipio, // Mapeando nome do município
            'estado'     => $this->dto->uf,
            'cep'        => $this->dto->cep,
        ];

        if ($exists) {            
            $this->update(
                $this->table,
                $data,
                'idEmitente = :ID',
                [':ID' => $this->dto->id]
            );
        } else {            
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {        
        return count($this->select($this->table, 'idEmitente = :ID', [':ID' => $this->dto->id])) > 0;
    }
}
