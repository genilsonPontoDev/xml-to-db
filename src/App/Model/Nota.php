<?php

namespace App\Model;

use App\DTO\DtoNota;
use Core\Model;

class Nota extends Model
{
    public $table = 'notafiscal'; // Nome correto da tabela
    public $dto;

    public function __construct(DtoNota $nota)
    {
        parent::__construct();
        $this->dto = $nota;
    }

    public function save(): DtoNota
    {
        $exists = $this->exists();

        $data = [
            'numero'         => $this->dto->nNF,
            'dataEmissao'    => $this->dto->dhEmi,
            'valorTotalNota' => $this->dto->vNF,
            'idEmitente'     => $this->getEmitenteId(),
            'idDestinatario' => $this->getDestinatarioId(),
        ];

        if ($exists) {
            $this->update(
                $this->table,
                $data,
                'idNotaFiscal = :ID',
                [':ID' => $this->dto->idNota]
            );
        } else {
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {
        return count($this->select($this->table, 'idNotaFiscal = :ID', [':ID' => $this->dto->idNota])) > 0;
    }

    private function getEmitenteId(): ?int
    {
        $result = $this->select('Emitente', 'cnpj = :CNPJ', [':CNPJ' => $this->dto->emitCNPJ]);
        return $result[0]['idEmitente'] ?? null;
    }

    private function getDestinatarioId(): ?int
    {
        $result = $this->select('Destinatario', 'cnpj = :CNPJ', [
            ':CNPJ' => $this->dto->destCNPJ,
        ]);

        return $result[0]['idDestinatario'] ?? null;
    }
}
