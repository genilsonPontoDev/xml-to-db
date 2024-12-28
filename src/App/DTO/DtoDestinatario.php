<?php

namespace App\DTO;

class DtoDestinatario
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
        $dest = $xml->NFe->infNFe->dest ?? null;
        $enderDest = $dest->enderDest ?? null;

        $this->id = $xml->ID ?? null;
        $this->tipoUsuario = "dest";
        $this->cnpj = (string) $dest->CNPJ ?? null;
        $this->nome = (string) $dest->xNome ?? null;
        $this->nomeFantasia = (string) $dest->xFant ?? null;
        $this->logradouro = (string) $enderDest->xLgr ?? null;
        $this->numero = (string) $enderDest->nro ?? null;
        $this->complemento = (string) $enderDest->xCpl ?? null;
        $this->bairro = (string) $enderDest->xBairro ?? null;
        $this->codigoMunicipio = (string) $enderDest->cMun ?? null;
        $this->nomeMunicipio = (string) $enderDest->xMun ?? null;
        $this->uf = (string) $enderDest->UF ?? null;
        $this->cep = (string) $enderDest->CEP ?? null;
        $this->codigoPais = (string) $enderDest->cPais ?? null;
        $this->nomePais = (string) $enderDest->xPais ?? null;
        $this->telefone = (string) $enderDest->fone ?? null;
        $this->inscricaoEstadual = (string) $dest->IE ?? null;
        $this->crt = (string) $dest->CRT ?? null;
    }
}
