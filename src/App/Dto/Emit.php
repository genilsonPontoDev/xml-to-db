<?php

namespace App\Dto;

class Emit
{
    public $CNPJ;
    public $xNome;
    public $enderEmit;

    public function __construct($emitXmlString)
    {
        if (empty($emitXmlString)) {
            throw new \Exception("Emitente não encontrado no XML.");
        }

        $xml = simplexml_load_string($emitXmlString);

        // Extrair diretamente os dados do XML
        $this->CNPJ = (string) $xml->CNPJ;
        $this->xNome = (string) $xml->Nome;

        // Tratamento do Endereço
        $this->enderEmit = $this->parseEnderEmit($xml->Endereco ?? null);
    }

    /**
     * Mapeia os dados do endereço do emitente
     */
    private function parseEnderEmit($enderEmitXml)
    {
        if (!$enderEmitXml) {
            return [];
        }

        return [
            'xLgr' => (string)($enderEmitXml->Logradouro ?? ''),
            'nro' => (string)($enderEmitXml->Numero ?? ''),
            'xBairro' => (string)($enderEmitXml->Bairro ?? ''),
            'CEP' => (string)($enderEmitXml->CEP ?? ''),
            'xCidade' => (string)($enderEmitXml->Cidade ?? ''),
            'xEstado' => (string)($enderEmitXml->Estado ?? ''),
        ];
    }
}
