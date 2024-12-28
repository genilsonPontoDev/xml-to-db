<?php

namespace App\DTO;

class DtoEmitente
{
    public $id;                // ID do emitente (se aplicável)
    public $tipoUsuario;       // Tipo de usuário ("emitente")
    public $cnpj;              // CNPJ do emitente
    public $nome;              // Razão social
    public $nomeFantasia;      // Nome fantasia
    public $logradouro;        // Logradouro
    public $numero;            // Número
    public $complemento;       // Complemento
    public $bairro;            // Bairro
    public $codigoMunicipio;   // Código do município
    public $nomeMunicipio;     // Nome do município
    public $uf;                // Unidade Federativa
    public $cep;               // CEP
    public $codigoPais;        // Código do país
    public $nomePais;          // Nome do país
    public $telefone;          // Telefone
    public $inscricaoEstadual; // Inscrição Estadual
    public $crt;               // Código de Regime Tributário

    public function __construct($xml)
    {
        $emit = $xml->NFe->infNFe->emit ?? null;
        $enderEmit = $emit->enderEmit ?? null;

        $this->id = $xml->ID ?? null;
        $this->tipoUsuario = "emit";
        $this->cnpj = (string) $emit->CNPJ ?? null;
        $this->nome = (string) $emit->xNome ?? null;
        $this->nomeFantasia = (string) $emit->xFant ?? null;
        $this->logradouro = (string) $enderEmit->xLgr ?? null;
        $this->numero = (string) $enderEmit->nro ?? null;
        $this->complemento = (string) $enderEmit->xCpl ?? null;
        $this->bairro = (string) $enderEmit->xBairro ?? null;
        $this->codigoMunicipio = (string) $enderEmit->cMun ?? null;
        $this->nomeMunicipio = (string) $enderEmit->xMun ?? null;
        $this->uf = (string) $enderEmit->UF ?? null;
        $this->cep = (string) $enderEmit->CEP ?? null;
        $this->codigoPais = (string) $enderEmit->cPais ?? null;
        $this->nomePais = (string) $enderEmit->xPais ?? null;
        $this->telefone = (string) $enderEmit->fone ?? null;
        $this->inscricaoEstadual = (string) $emit->IE ?? null;
        $this->crt = (string) $emit->CRT ?? null;
    }
}
