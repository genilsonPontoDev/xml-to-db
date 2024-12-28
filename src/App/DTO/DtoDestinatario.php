<?php

namespace App\DTO;

class DtoDestinatario
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
