<?php
namespace App\UseCase;

use App\Library\Bucket;
use App\Library\ReadXml;
use App\Model\Emitente;
use App\Model\Destinatario;
use App\Model\Nota;
use App\Model\ItensNota;
use App\DTO\DtoEmitente;
use App\DTO\DtoDestinatario;
use App\DTO\DtoNota;
use App\DTO\DtoItensNota;

class SaveNfe
{

    private $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    function getXmlList()
    {
        $bucket = new Bucket($this->config);        
        return ($bucket->list()) ?? [];        
    }

    function getXml(): string
    {
        $xmlList = $this->getXmlList();
        foreach ($xmlList as $xml) {
            $fileName = array_keys($xml)[0];
            $nf = $xml[$fileName][0];    
            $xml = simplexml_load_string($nf);
            $xml->addChild('file', $fileName);
            $nf = $xml->asXML();            
            return $nf ?? "";
        }        
    }

    function saveEmit($xml): DtoEmitente
    {
        $emit = new DtoEmitente($xml);
        $model = new Emitente($emit);
        return $model->save();
    }

    function saveDest($xml): DtoDestinatario
    {
        $dest = new DtoDestinatario($xml);
        $model = new Destinatario($dest);
        return $model->save();
    }

    function saveNota($xml): DtoNota
    {
        $nota = new DtoNota($xml);
        $model = new Nota($nota);
        return $model->save();
    }

    function saveItensNota($xml): DtoItensNota
    {
        $itensNota = new DtoItensNota($xml);
        $model = new ItensNota($itensNota);
        return $model->save();
    }

    function registerResponse($notaSaved, $emitSaved, $destSaved, $prodSaved, $fileSaved)
    {
        try {
            $mensagem = '';

            if ($notaSaved && $emitSaved && $destSaved && $prodSaved) {
                $mensagem = 'Nota inserida com sucesso';
            } else {
                $mensagem = 'erro ao inserir nota';
            }
            
            $response = [
                "mensagem" => $mensagem,
                "numeroNota" => $notaSaved,
                "emitente" => $emitSaved,
                "destinatario" => $destSaved,
                "produto" => $prodSaved,
                "arquivo" => $fileSaved
            ];

            header('Content-Type: application/json');
            echo json_encode($response);
        } catch (Exception $e) {
            
            $errorResponse = [
                "mensagem" => "Erro ao processar a nota",
                "detalhes" => $e->getMessage()
            ];

            http_response_code(500);
            echo json_encode($errorResponse);
        }
    }

    /* function saveNfe($xml) {
        $dto = new dtoNFE();
        $model = new NFE();
        $model->save();
    }
 */
    function register()
    {        
        $xml = $this->getXml();        
        $xml = ReadXml::parse($xml);         
        $IDEmitente = $this->saveEmit($xml);
        $IDDestinatario = $this->saveDest($xml);
        $IDNota = $this->saveNota($xml);
        $IDItensNota = $this->saveItensNota($xml);
        $notaSaved = $IDNota->cNF;
        $emitSaved = $IDEmitente->cnpj;
        $destSaved = $IDDestinatario->cnpj;
        $prodSaved = $IDItensNota->xProd; 
        $fileSaved = (string) $xml->file;
        $this->registerResponse($notaSaved, $emitSaved, $destSaved, $prodSaved, $fileSaved);

        /* $ID = $this->emitNfe($ID, $xml);
        $ID = $this->destNfe($ID, $xml);
        $ID = $this->saveNfe($xml);

        $this-itens($ID, $xml); */
    }
}