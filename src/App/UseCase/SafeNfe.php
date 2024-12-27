<?php

use App\Library\Bucket;
use App\Library\ReadXml;
use App\Model\Nfe;
use App\Model\Emitente;

class SafeNfe {
    public function __construct() {

    }

    function getXml (): string {
        $bucket = new Bucket();
        return ($bucket->list()) ?? "";
    }

    function emitNfe($ID, $xml): Emitente {
        $emit = new Emitente($ID, $xml);
        $emit->save();
    }

    function saveNfe($xml) {
        $dto = new dtoNFE();
        $model = new NFE();
        $model->save();
    }

    function register() {
        $xml = $this->getXml();
        $xml = ReadXml::parse($xml);

        $ID = $this->emitNfe($ID, $xml);
        $ID = $this->destNfe($ID, $xml);
        $ID = $this->saveNfe($xml);

        $this-itens($ID, $xml);
    }
}