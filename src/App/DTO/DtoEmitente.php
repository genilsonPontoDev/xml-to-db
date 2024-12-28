<?php

namespace App\DTO;

class DtoEmitente
{
    public $ID;
    public $name;
    public function __construct($xml) {        
        $this->ID = $xml->ID ?? null;
        $this->name = (string) $xml->NFe->infNFe->emit->xNome ?? null;
        //var_dump($this->name); die();
    }
}
