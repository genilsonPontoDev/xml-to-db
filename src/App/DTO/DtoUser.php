<?php

namespace App\Dto;

class User
{
    public $idUsuario;
    public $usuarioCriadorId;
    public $matrizId;
    public $nome;
    public $cpf;
    public $email;
    public $senha;
    public $imagem;
    public $statusConta;
    public $reputacao;
    public $razaoSocial;
    public $nomeFantasia;
    public $cnpj;
    public $inscEstadual;
    public $inscMunicipal;
    public $mostrarNoSite;
    public $descricao;
    public $tipo;
    public $tipoDeMoeda;
    public $status;
    public $restricao;
    public $nomeContato;
    public $telefone;
    public $celular;
    public $emailContato;
    public $emailSecundario;
    public $site;
    public $logradouro;
    public $numero;
    public $cep;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;
    public $regiao;
    public $aceitaOrcamento;
    public $aceitaVoucher;
    public $tipoOperacao;
    public $categoriaId;
    public $subcategoriaId;
    public $taxaComissaoGerente;
    public $permissoesDoUsuario;
    public $tokenResetSenha;
    public $bloqueado;

    public function __construct(array $data = [])
    {
        foreach ($this->whiteList() as $key) {
            $this->{$key} = $data[$key] ?? null;
        }

        $this->permissoesDoUsuario = '["ALL"]';
        $this->tipo = 'Gerente';
    }

    public function whiteList()
    {
        return [
            'idUsuario',
            'usuarioCriadorId',
            'matrizId',
            'nome',
            'cpf',
            'email',
            'senha',
            'imagem',
            'statusConta',
            'reputacao',
            'razaoSocial',
            'nomeFantasia',
            'cnpj',
            'inscEstadual',
            'inscMunicipal',
            'mostrarNoSite',
            'descricao',
            'tipo',
            'tipoDeMoeda',
            'status',
            'restricao',
            'nomeContato',
            'telefone',
            'celular',
            'emailContato',
            'emailSecundario',
            'site',
            'logradouro',
            'numero',
            'cep',
            'complemento',
            'bairro',
            'cidade',
            'estado',
            'regiao',
            'aceitaOrcamento',
            'aceitaVoucher',
            'tipoOperacao',
            'categoriaId',
            'subcategoriaId',
            'taxaComissaoGerente',
            'permissoesDoUsuario',
            'tokenResetSenha',
            'bloqueado'
        ];
    }
}
