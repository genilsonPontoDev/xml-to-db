<?php

namespace App\Model;

use App\DTO\DtoEmitente;
use Core\Model;

class Emitente extends Model
{
    public $table = 'usuario_nota';
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
            'tipo_usuario' => 'emit',
            'CNPJ' => $this->dto->cnpj,
            'xNome' => $this->dto->nome,
            'xFant' => $this->dto->nomeFantasia,
            'xLgr' => $this->dto->logradouro,
            'nro' => $this->dto->numero,
            'xCpl' => $this->dto->complemento,
            'xBairro' => $this->dto->bairro,
            'cMun' => $this->dto->codigoMunicipio,
            'xMun' => $this->dto->nomeMunicipio,
            'UF' => $this->dto->uf,
            'CEP' => $this->dto->cep,
            'cPais' => $this->dto->codigoPais,
            'xPais' => $this->dto->nomePais,
            'fone' => $this->dto->telefone,
            'IE' => $this->dto->inscricaoEstadual,
            'CRT' => $this->dto->crt,
        ];

        if ($exists) {            
            $this->update(
                $this->table,
                $data,
                'id_usuario = :ID',
                [':ID' => $this->dto->id]
            );
        } else {            
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {        
        return count($this->select($this->table, 'id_usuario = :ID', [':ID' => $this->dto->id])) > 0;
    }
}
