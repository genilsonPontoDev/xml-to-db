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
            'CNPJ' => $this->dto->cnpj, // Corrigido
            'xNome' => $this->dto->nome, // Corrigido
            'xFant' => $this->dto->nomeFantasia, // Corrigido
            'xLgr' => $this->dto->logradouro, // Corrigido
            'nro' => $this->dto->numero, // Corrigido
            'xCpl' => $this->dto->complemento, // Corrigido
            'xBairro' => $this->dto->bairro, // Corrigido
            'cMun' => $this->dto->codigoMunicipio, // Corrigido
            'xMun' => $this->dto->nomeMunicipio, // Corrigido
            'UF' => $this->dto->uf, // Corrigido
            'CEP' => $this->dto->cep, // Corrigido
            'cPais' => $this->dto->codigoPais, // Corrigido
            'xPais' => $this->dto->nomePais, // Corrigido
            'fone' => $this->dto->telefone, // Corrigido
            'IE' => $this->dto->inscricaoEstadual, // Corrigido
            'CRT' => $this->dto->crt, // Corrigido
        ];

        if ($exists) {
            var_dump('atualiza');
            $this->update(
                $this->table,
                $data,
                'id_usuario = :ID',
                [':ID' => $this->dto->id]
            );
        } else {
            var_dump('insere');
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {        
        return count($this->select($this->table, 'id_usuario = :ID', [':ID' => $this->dto->id])) > 0;
    }
}
