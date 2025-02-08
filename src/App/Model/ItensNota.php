<?php

namespace App\Model;

use App\DTO\DtoItensNota;
use Core\Model;

class ItensNota extends Model
{
    public $table = 'Item'; // Nome correto da tabela
    public $dto;

    public function __construct(DtoItensNota $itemNota)
    {
        parent::__construct();
        $this->dto = $itemNota;
    }

    public function save(): DtoItensNota
    {
        // Verifique se o idNotaFiscal (idNota) não é nulo ou vazio
        if (empty($this->dto->idNota)) {
            throw new \Exception('O campo idNotaFiscal (idNota) é obrigatório e não pode ser nulo.');
        }

        $exists = $this->exists();

        $data = [
            'idNotaFiscal'  => $this->dto->idNota,    // Campo para idNotaFiscal
            'numeroItem'    => $this->dto->nItem,     // Número do item na nota
            'descricao'     => $this->dto->xProd,     // Descrição do produto
            'quantidade'    => $this->dto->qCom,      // Quantidade
            'valorUnitario' => $this->dto->vUnCom,    // Valor unitário
            'valorTotal'    => $this->dto->vProd,     // Valor total
        ];

        if ($exists) {
            $this->update(
                $this->table,
                $data,
                'idItem = :ID', // Ajuste para a chave primária 'idItem'
                [':ID' => $this->dto->idItem] // Parâmetro de 'idItem'
            );
        } else {
            $this->insert($this->table, $data); // Inserir novo registro
        }

        return $this->dto; // Retorna o DTO com os dados
    }


    public function exists(): bool
    {
        return count($this->select($this->table, 'idItem = :ID', [':ID' => $this->dto->idItem])) > 0; // Verifica se o item já existe
    }
}
