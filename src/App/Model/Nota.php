<?php

namespace App\Model;

use App\DTO\DtoNota;
use Core\Model;

class Nota extends Model
{
    public $table = 'nota';
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
            'id_nota' => $this->dto->idNota,
            'cUF' => $this->dto->cUF,
            'cNF' => $this->dto->cNF,
            'natOp' => $this->dto->natOp,
            'mod' => $this->dto->mod,
            'serie' => $this->dto->serie,
            'nNF' => $this->dto->nNF,
            'dhEmi' => $this->dto->dhEmi,
            'dhSaiEnt' => $this->dto->dhSaiEnt,
            'tpNF' => $this->dto->tpNF,
            'idDest' => $this->dto->idDest,
            'cMunFG' => $this->dto->cMunFG,
            'tpImp' => $this->dto->tpImp,
            'tpEmis' => $this->dto->tpEmis,
            'cDV' => $this->dto->cDV,
            'tpAmb' => $this->dto->tpAmb,
            'finNFe' => $this->dto->finNFe,
            'indFinal' => $this->dto->indFinal,
            'indPres' => $this->dto->indPres,
            'procEmi' => $this->dto->procEmi,
            'verProc' => $this->dto->verProc,
            'emit_CNPJ' => $this->dto->emitCNPJ,
            'dest_CNPJ' => $this->dto->destCNPJ,
            'vBC' => $this->dto->vBC,
            'vICMS' => $this->dto->vICMS,
            'vICMSDeson' => $this->dto->vICMSDeson,
            'vFCP' => $this->dto->vFCP,
            'vBCST' => $this->dto->vBCST,
            'vST' => $this->dto->vST,
            'vFCPST' => $this->dto->vFCPST,
            'vFCPSTRet' => $this->dto->vFCPSTRet,
            'vProd' => $this->dto->vProd,
            'vFrete' => $this->dto->vFrete,
            'vSeg' => $this->dto->vSeg,
            'vDesc' => $this->dto->vDesc,
            'vII' => $this->dto->vII,
            'vIPI' => $this->dto->vIPI,
            'vIPIDevol' => $this->dto->vIPIDevol,
            'vPIS' => $this->dto->vPIS,
            'vCOFINS' => $this->dto->vCOFINS,
            'vOutro' => $this->dto->vOutro,
            'vNF' => $this->dto->vNF,
            'vTotTrib' => $this->dto->vTotTrib,
        ];

        if ($exists) {
            $this->update(
                $this->table,
                $data,
                'id_nota = :ID',
                [':ID' => $this->dto->idNota]
            );
        } else {
            $this->insert($this->table, $data);
        }

        return $this->dto;
    }

    public function exists(): bool
    {
        return count($this->select($this->table, 'id_nota = :ID', [':ID' => $this->dto->idNota])) > 0;
    }
}
