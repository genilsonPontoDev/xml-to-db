<?php

namespace App\DTO;

class DtoItensNota
{
    public $idItem;
    public $idNota;
    public $nItem;
    public $cProd;
    public $cEAN;
    public $xProd;
    public $NCM;
    public $CFOP;
    public $uCom;
    public $qCom;
    public $vUnCom;
    public $vProd;
    public $cEANTrib;
    public $uTrib;
    public $qTrib;
    public $vUnTrib;
    public $indTot;
    public $vTotTrib;
    public $orig;
    public $CST_ICMS;
    public $CST_PIS;
    public $vBC_PIS;
    public $pPIS;
    public $vPIS;
    public $CST_COFINS;
    public $vBC_COFINS;
    public $pCOFINS;
    public $vCOFINS;

    // Novos campos
    public $modBC;
    public $vBC_ICMS;
    public $pICMS;
    public $vICMS;

    public function __construct($xmlItem)
    {
        // Acessando os campos do XML com os caminhos completos

        // Informações do item
        $this->nItem = (string) $xmlItem->NFe->infNFe->det->nItem ?? null;
        $this->cProd = (string) $xmlItem->NFe->infNFe->det->prod->cProd ?? null;
        $this->cEAN = (string) $xmlItem->NFe->infNFe->det->prod->cEAN ?? null;
        $this->xProd = (string) $xmlItem->NFe->infNFe->det->prod->xProd ?? null;
        $this->NCM = (string) $xmlItem->NFe->infNFe->det->prod->NCM ?? null;
        $this->CFOP = (string) $xmlItem->NFe->infNFe->det->prod->CFOP ?? null;
        $this->uCom = (string) $xmlItem->NFe->infNFe->det->prod->uCom ?? null;
        $this->qCom = (string) $xmlItem->NFe->infNFe->det->prod->qCom ?? null;
        $this->vUnCom = (string) $xmlItem->NFe->infNFe->det->prod->vUnCom ?? null;
        $this->vProd = (string) $xmlItem->NFe->infNFe->det->prod->vProd ?? null;
        $this->cEANTrib = (string) $xmlItem->NFe->infNFe->det->prod->cEANTrib ?? null;
        $this->uTrib = (string) $xmlItem->NFe->infNFe->det->prod->uTrib ?? null;
        $this->qTrib = (string) $xmlItem->NFe->infNFe->det->prod->qTrib ?? null;
        $this->vUnTrib = (string) $xmlItem->NFe->infNFe->det->prod->vUnTrib ?? null;
        $this->indTot = (string) $xmlItem->NFe->infNFe->det->prod->indTot ?? null;

        // Informações de impostos
        $this->vTotTrib = (string) $xmlItem->NFe->infNFe->det->imposto->vTotTrib ?? null;

        // ICMS
        $this->orig = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->orig ?? null;
        $this->CST_ICMS = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->CST ?? null;
        $this->modBC = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->modBC ?? null;
        $this->vBC_ICMS = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->vBC ?? null;
        $this->pICMS = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->pICMS ?? null;
        $this->vICMS = (string) $xmlItem->NFe->infNFe->det->imposto->ICMS->ICMS90->vICMS ?? null;

        // PIS
        $this->CST_PIS = (string) $xmlItem->NFe->infNFe->det->imposto->PIS->PISOutr->CST ?? null;
        $this->vBC_PIS = (string) $xmlItem->NFe->infNFe->det->imposto->PIS->PISOutr->vBC ?? null;
        $this->pPIS = (string) $xmlItem->NFe->infNFe->det->imposto->PIS->PISOutr->pPIS ?? null;
        $this->vPIS = (string) $xmlItem->NFe->infNFe->det->imposto->PIS->PISOutr->vPIS ?? null;

        // COFINS
        $this->CST_COFINS = (string) $xmlItem->NFe->infNFe->det->imposto->COFINS->COFINSOutr->CST ?? null;
        $this->vBC_COFINS = (string) $xmlItem->NFe->infNFe->det->imposto->COFINS->COFINSOutr->vBC ?? null;
        $this->pCOFINS = (string) $xmlItem->NFe->infNFe->det->imposto->COFINS->COFINSOutr->pCOFINS ?? null;
        $this->vCOFINS = (string) $xmlItem->NFe->infNFe->det->imposto->COFINS->COFINSOutr->vCOFINS ?? null;
    }
}
