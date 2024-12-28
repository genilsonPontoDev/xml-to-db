<?php

namespace App\Model;

use App\DTO\DtoItensNota;
use Core\Model;

class ItensNota extends Model
{
    public $table = 'itens_nota';
    public $dto;

    public function __construct(DtoItensNota $itemNota)
    {
        parent::__construct();
        $this->dto = $itemNota;        
    }

    public function save(): DtoItensNota
    {
        $exists = $this->exists();

        $data = [
            'id_nota' => $this->dto->idNota,
            'nItem' => $this->dto->nItem,
            'cProd' => $this->dto->cProd,
            'cEAN' => $this->dto->cEAN,
            'xProd' => $this->dto->xProd,
            'NCM' => $this->dto->NCM,
            'CFOP' => $this->dto->CFOP,
            'uCom' => $this->dto->uCom,
            'qCom' => $this->dto->qCom,
            'vUnCom' => $this->dto->vUnCom,
            'vProd' => $this->dto->vProd,
            'cEANTrib' => $this->dto->cEANTrib,
            'uTrib' => $this->dto->uTrib,
            'qTrib' => $this->dto->qTrib,
            'vUnTrib' => $this->dto->vUnTrib,
            'indTot' => $this->dto->indTot,
            'vTotTrib' => $this->dto->vTotTrib,
            'orig' => $this->dto->orig,
            'CST_ICMS' => $this->dto->CST_ICMS,
            'CST_PIS' => $this->dto->CST_PIS,
            'vBC_PIS' => $this->dto->vBC_PIS,
            'pPIS' => $this->dto->pPIS,
            'vPIS' => $this->dto->vPIS,
            'CST_COFINS' => $this->dto->CST_COFINS,
            'vBC_COFINS' => $this->dto->vBC_COFINS,
            'pCOFINS' => $this->dto->pCOFINS,
            'vCOFINS' => $this->dto->vCOFINS,
        ];

        if ($exists) {
            $this->update(
                $this->table,
                $data,
                'id_item = :ID',
                [':ID' => $this->dto->idItem]
            );
        } else {
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {
        return count($this->select($this->table, 'id_item = :ID', [':ID' => $this->dto->idItem])) > 0;
    }
}
