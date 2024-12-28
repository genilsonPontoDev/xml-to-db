<?php

namespace App\DTO;

class DtoNota
{
    public $idNota;           // ID da nota
    public $cUF;              // Código da UF
    public $cNF;              // Código numérico
    public $natOp;            // Natureza da operação
    public $mod;              // Modelo da nota
    public $serie;            // Série
    public $nNF;              // Número da nota
    public $dhEmi;            // Data e hora de emissão
    public $dhSaiEnt;         // Data e hora de saída/entrada
    public $tpNF;             // Tipo da nota fiscal
    public $idDest;           // Identificador do destinatário
    public $cMunFG;           // Código do município de ocorrência do fato gerador
    public $tpImp;            // Tipo de impressão
    public $tpEmis;           // Tipo de emissão
    public $cDV;              // Código de verificação
    public $tpAmb;            // Tipo de ambiente
    public $finNFe;           // Finalidade da emissão
    public $indFinal;         // Indicador de consumidor final
    public $indPres;          // Indicador de presença
    public $procEmi;          // Processo de emissão
    public $verProc;          // Versão do processo
    public $emitCNPJ;         // CNPJ do emitente
    public $destCNPJ;         // CNPJ do destinatário
    public $vBC;              // Base de cálculo do ICMS
    public $vICMS;            // Valor do ICMS
    public $vICMSDeson;       // Valor do ICMS desonerado
    public $vFCP;             // Valor do FCP
    public $vBCST;            // Base de cálculo do ICMS ST
    public $vST;              // Valor do ICMS ST
    public $vFCPST;           // Valor do FCP ST
    public $vFCPSTRet;        // Valor do FCP ST retido
    public $vProd;            // Valor total dos produtos
    public $vFrete;           // Valor do frete
    public $vSeg;             // Valor do seguro
    public $vDesc;            // Valor do desconto
    public $vII;              // Valor do II
    public $vIPI;             // Valor do IPI
    public $vIPIDevol;        // Valor do IPI devolvido
    public $vPIS;             // Valor do PIS
    public $vCOFINS;          // Valor do COFINS
    public $vOutro;           // Outros valores
    public $vNF;              // Valor total da nota fiscal
    public $vTotTrib;         // Valor total dos tributos

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
