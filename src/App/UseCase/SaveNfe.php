<?php
namespace App\UseCase;

use App\Library\Bucket;
use App\Library\ReadXml;
use App\Model\Nfe;
use App\Model\Emitente;
use App\DTO\DtoEmitente;

class SaveNfe {

    private $config;
    public function __construct($config) {
        $this->config = $config;
    }

    function getXml (): string {
        $bucket = new Bucket($this->config);
        return ($bucket->list()) ?? "";
    }

    function saveEmit($xml): DtoEmitente {        
        $emit = new DtoEmitente($xml);
        $model = new Emitente($emit);             
        return $model->save();
    }

    /* function saveNfe($xml) {
        $dto = new dtoNFE();
        $model = new NFE();
        $model->save();
    }
 */
    function register() {
        $xml = $this->getXml();
        $xml = ReadXml::parse($xml);        
        $IDEmitente = $this->saveEmit($xml);      

        /* $ID = $this->emitNfe($ID, $xml);
        $ID = $this->destNfe($ID, $xml);
        $ID = $this->saveNfe($xml);

        $this-itens($ID, $xml); */
    }
}