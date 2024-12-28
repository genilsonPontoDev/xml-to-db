<?php

namespace App\DTO;

class DtoEmitente
{
    public $id;
    public $tipoUsuario;
    public $cnpj;
    public $nome;
    public $nomeFantasia;
    public $logradouro;
    public $numero;
    public $complemento;
    public $bairro;
    public $codigoMunicipio;
    public $nomeMunicipio;
    public $uf;
    public $cep;
    public $codigoPais;
    public $nomePais;
    public $telefone;
    public $inscricaoEstadual;
    public $crt;

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
