<?php

namespace App\Dto;

class Emit
{
    public $CNPJ;
    public $xNome;
    public $xFant;
    public $xLgr;
    public $nro;
    public $xCpl;
    public $xBairro;
    public $cMun;
    public $xMun;
    public $UF;
    public $CEP;
    public $cPais;
    public $xPais;
    public $fone;
    public $IE;
    public $CRT;

    public function __construct($emitXmlString)
    {
        if (empty($emitXmlString)) {
            throw new \Exception("Emitente não encontrado no XML.");
        }

        $xml = simplexml_load_string($emitXmlString);

        // Extrair diretamente os dados do XML
        $this->CNPJ = (string) $xml->CNPJ;
        $this->xNome = (string) $xml->Nome;
        $this->xFant = (string) $xml->NomeFantasia;
        $this->xLgr = (string) $xml->Endereco->Logradouro;
        $this->nro = (string) $xml->Endereco->Numero;
        $this->xCpl = (string) $xml->Endereco->Complemento;
        $this->xBairro = (string) $xml->Endereco->Bairro;
        $this->CEP = (string) $xml->Endereco->CEP;
        $this->xMun = (string) $xml->Endereco->Cidade;
        $this->UF = (string) $xml->Endereco->Estado;
        $this->cMun = (string) $xml->Endereco->CodigoMunicipio;
        $this->cPais = (string) $xml->Endereco->CodigoPais;
        $this->xPais = (string) $xml->Endereco->Pais;
        $this->fone = (string) $xml->Telefone;
        $this->IE = (string) $xml->InscricaoEstadual;
        $this->CRT = (string) $xml->CRT;
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
            'cMun' => (string)($enderEmitXml->CodigoMunicipio ?? ''),
            'cPais' => (string)($enderEmitXml->CodigoPais ?? ''),
            'xPais' => (string)($enderEmitXml->Pais ?? ''),
        ];
    }
}
