<?php

namespace App\Model;

use App\DTO\DtoEmitente;
use Core\Model;

class Emitente extends Model
{
    private $ID;
    public $xml;

    public $dto;

    public function __construct(DtoEmitente $emitente) {
        parent::__construct();
        $this->dto = new DtoEmitente();
    }

    function save (): DtoEmitente {        
        return $this->dto;
    }
}
