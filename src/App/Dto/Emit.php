<?php

namespace App\Dto;

class Emit {
    public $CNPJ;
    public $xNome;
    public $enderEmit;

    public function __construct($xmlString)
    {
        $xml = $this->parseXml($xmlString);        
        $this->CNPJ = $xml->infNFe->emit->CNPJ ?? null;
        //$this->CNPJ = $this->setCNPJ($xml->infNFe->emit->CNPJ);
    }

    public function parseXml ($xml) {
        return simplexml_load_string($xml);
    }

    public function setCNPJ () {
        
    }
}