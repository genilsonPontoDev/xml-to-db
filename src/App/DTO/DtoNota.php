<?php

namespace App\DTO;

class DtoNota
{
    public $idNota;
    public $cUF;
    public $cNF;
    public $natOp;
    public $mod;
    public $serie;
    public $nNF;
    public $dhEmi;
    public $dhSaiEnt;
    public $tpNF;
    public $idDest;
    public $cMunFG;
    public $tpImp;
    public $tpEmis;
    public $cDV;
    public $tpAmb;
    public $finNFe;
    public $indFinal;
    public $indPres;
    public $procEmi;
    public $verProc;
    public $emitCNPJ;
    public $destCNPJ;
    public $vBC;
    public $vICMS;
    public $vICMSDeson;
    public $vFCP;
    public $vBCST;
    public $vST;
    public $vFCPST;
    public $vFCPSTRet;
    public $vProd;
    public $vFrete;
    public $vSeg;
    public $vDesc;
    public $vII;
    public $vIPI;
    public $vIPIDevol;
    public $vPIS;
    public $vCOFINS;
    public $vOutro;
    public $vNF;
    public $vTotTrib;

    public function __construct($xml)
    {
        $infNFe = $xml->NFe->infNFe ?? null;
        $total = $infNFe->total->ICMSTot ?? null;

        $this->idNota = (string) $xml->ID ?? null;
        $this->cUF = (string) $infNFe->ide->cUF ?? null;
        $this->cNF = (string) $infNFe->ide->cNF ?? null;
        $this->natOp = (string) $infNFe->ide->natOp ?? null;
        $this->mod = (string) $infNFe->ide->mod ?? null;
        $this->serie = (string) $infNFe->ide->serie ?? null;
        $this->nNF = (string) $infNFe->ide->nNF ?? null;
        $this->dhEmi = (string) $infNFe->ide->dhEmi ?? null;
        $this->dhSaiEnt = (string) $infNFe->ide->dhSaiEnt ?? null;
        $this->tpNF = (string) $infNFe->ide->tpNF ?? null;
        $this->idDest = (string) $infNFe->ide->idDest ?? null;
        $this->cMunFG = (string) $infNFe->ide->cMunFG ?? null;
        $this->tpImp = (string) $infNFe->ide->tpImp ?? null;
        $this->tpEmis = (string) $infNFe->ide->tpEmis ?? null;
        $this->cDV = (string) $infNFe->ide->cDV ?? null;
        $this->tpAmb = (string) $infNFe->ide->tpAmb ?? null;
        $this->finNFe = (string) $infNFe->ide->finNFe ?? null;
        $this->indFinal = (string) $infNFe->ide->indFinal ?? null;
        $this->indPres = (string) $infNFe->ide->indPres ?? null;
        $this->procEmi = (string) $infNFe->ide->procEmi ?? null;
        $this->verProc = (string) $infNFe->ide->verProc ?? null;
        $this->emitCNPJ = (string) $infNFe->emit->CNPJ ?? null;
        $this->destCNPJ = (string) $infNFe->dest->CNPJ ?? null;
        $this->vBC = (string) $total->vBC ?? null;
        $this->vICMS = (string) $total->vICMS ?? null;
        $this->vICMSDeson = (string) $total->vICMSDeson ?? null;
        $this->vFCP = (string) $total->vFCP ?? null;
        $this->vBCST = (string) $total->vBCST ?? null;
        $this->vST = (string) $total->vST ?? null;
        $this->vFCPST = (string) $total->vFCPST ?? null;
        $this->vFCPSTRet = (string) $total->vFCPSTRet ?? null;
        $this->vProd = (string) $total->vProd ?? null;
        $this->vFrete = (string) $total->vFrete ?? null;
        $this->vSeg = (string) $total->vSeg ?? null;
        $this->vDesc = (string) $total->vDesc ?? null;
        $this->vII = (string) $total->vII ?? null;
        $this->vIPI = (string) $total->vIPI ?? null;
        $this->vIPIDevol = (string) $total->vIPIDevol ?? null;
        $this->vPIS = (string) $total->vPIS ?? null;
        $this->vCOFINS = (string) $total->vCOFINS ?? null;
        $this->vOutro = (string) $total->vOutro ?? null;
        $this->vNF = (string) $total->vNF ?? null;
        $this->vTotTrib = (string) $total->vTotTrib ?? null;
    }
}
