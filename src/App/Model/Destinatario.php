<?php

namespace App\Model;

use App\DTO\DtoDestinatario;
use Core\Model;

class Destinatario extends Model
{
    public $table = 'usuario_nota';
    public $dto;

    public function __construct(DtoDestinatario $destinatario)
    {
        parent::__construct();
        $this->dto = $destinatario;
    }

    public function save(): DtoDestinatario
    {
        $exists = $this->exists();

        $data = [
            'tipo_usuario' => 'dest',
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
