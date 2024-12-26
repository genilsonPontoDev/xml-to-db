<?php

namespace App\Dto;

use App\Model\Emitente;  // Importa a model Emitente
use Exception;

class Nfe
{
    private $xml;
    public $emit;

    public function __construct($xmlContent)
    {
        if (empty($xmlContent)) {
            throw new Exception("XML vazio ou inválido.");
        }
        
        // Carrega o XML e valida se é bem formado
        $this->xml = $xmlContent;
        
        if (!$this->xml) {
            throw new Exception("Erro ao processar o XML.");
        }
        
        // Extrai a parte do XML relacionada ao Emitente
        $emitXml = $this->extractXmlPart('emit');

        if ($emitXml) {
            $this->emit = new Emit($emitXml);        

            // Passa os dados para a Model Emitente
            $emitenteModel = new Emitente();
            
            // Mapeia todos os dados de Emitente
            $dados = [
                'CNPJ' => $this->emit->CNPJ,
                'xNome' => $this->emit->xNome,
                'xFant' => $this->emit->xFant,
                'xLgr' => $this->emit->enderEmit['xLgr'],
                'nro' => $this->emit->enderEmit['nro'],
                'xCpl' => $this->emit->enderEmit['xCpl'],
                'xBairro' => $this->emit->enderEmit['xBairro'],
                'cMun' => $this->emit->enderEmit['cMun'],
                'xMun' => $this->emit->xMun,
                'UF' => $this->emit->UF,
                'CEP' => $this->emit->CEP,
                'cPais' => $this->emit->cPais,
                'xPais' => $this->emit->xPais,
                'fone' => $this->emit->fone,
                'IE' => $this->emit->IE,
                'CRT' => $this->emit->CRT
            ];

            // Salva no banco
            $emitenteModel->save($dados);
        } else {
            throw new Exception("Tag Emitente não encontrada no XML.");
        }
    }
    
    /**
     * Extrai uma parte específica do XML com XPath
     * @param string $tag Nome da tag que será extraída
     * @return string|null XML correspondente à tag ou null se não encontrado
     */
    private function extractXmlPart($tag)
    {        
        // Executa a consulta XPath para a tag
        $element = $this->xml->xpath("//{$tag}");
        
        // Verifica se encontrou pelo menos um elemento
        if (!empty($element)) {
            return $element[0]->asXML();  // Retorna o XML da primeira ocorrência
        }
        
        return null;  // Retorna null caso não encontre
    }
}
