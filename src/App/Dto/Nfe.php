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
        $this->xml = simplexml_load_string($xmlContent);
        
        if (!$this->xml) {
            throw new Exception("Erro ao processar o XML.");
        }
        
        // Extrai a parte do XML relacionada ao Emitente
        $emitXml = $this->extractXmlPart('Emitente');
        
        if ($emitXml) {
            $this->emit = new Emit($emitXml);        

            // Passa os dados para a Model Emitente
            $emitenteModel = new Emitente();
            $dados = [
                'nome' => $this->emit->xNome,
                'cnpj' => $this->emit->CNPJ,
                'logradouro' => $this->emit->enderEmit['xLgr'],
                'numero' => $this->emit->enderEmit['nro'],
                'bairro' => $this->emit->enderEmit['xBairro'],
                'cidade' => $this->emit->enderEmit['xCidade'],
                'estado' => $this->emit->enderEmit['xEstado'],
                'cep' => $this->emit->enderEmit['CEP']
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
