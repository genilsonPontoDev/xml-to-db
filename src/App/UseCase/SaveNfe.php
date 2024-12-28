<?php
namespace App\UseCase;

use App\Library\Bucket;
use App\Library\ReadXml;
use App\Model\Nfe;
use App\Model\Emitente;
use App\Model\Destinatario;
use App\Model\Nota;
use App\Model\ItensNota;
use App\DTO\DtoEmitente;
use App\DTO\DtoDestinatario;
use App\DTO\DtoNota;
use App\DTO\DtoItensNota;

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
    function saveDest($xml): DtoDestinatario {        
        $dest = new DtoDestinatario($xml);
        $model = new Destinatario($dest);             
        return $model->save();
    }
    function saveNota($xml): DtoNota {        
        $nota = new DtoNota($xml);
        $model = new Nota($nota);        
        return $model->save();
    }
    function saveItensNota($xml): DtoItensNota {        
        $itensNota = new DtoItensNota($xml);
        $model = new ItensNota($itensNota);        
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
        $IDDestinatario = $this->saveDest($xml);      
        $IDNota = $this->saveNota($xml);  
        $IDItensNota = $this->saveItensNota($xml);        

        /* $ID = $this->emitNfe($ID, $xml);
        $ID = $this->destNfe($ID, $xml);
        $ID = $this->saveNfe($xml);

        $this-itens($ID, $xml); */
    }
}