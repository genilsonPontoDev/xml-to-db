<?php

namespace App\Model;

use App\DTO\DtoDestinatario;
use Core\Model;

class Destinatario extends Model
{
    public $table = 'destinatario'; // Alterado de usuario_nota para destinatario
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
            'nome'       => $this->dto->nome,
            'cnpj'        => $this->dto->cnpj,
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
                'idDestinatario = :ID',
                [':ID' => $this->dto->id]
            );
        } else {            
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {        
        return count($this->select($this->table, 'idDestinatario = :ID', [':ID' => $this->dto->id])) > 0;
    }
}
