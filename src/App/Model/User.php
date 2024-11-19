<?php

namespace App\Model;
use Core\Model;
use App\Dto\User as userDto;

class User extends Model {
    public $data;

    public function __construct(userDto $user) {
        $this->data = $user;
        parent::__construct();
    }

    public function inserirUsuario () {        
        $this->insert('Usuarios', [
            'usuarioCriadorId' => $this->data->usuarioCriadorId,
            'matrizId' => $this->data->matrizId,
            'nome' => $this->data->nome,
            'cpf' => $this->data->cpf,
            'email' => $this->data->email,
            'senha' => $this->data->senha,
            'imagem' => $this->data->imagem,
            'statusConta' => $this->data->statusConta,
            'reputacao' => $this->data->reputacao,
            'razaoSocial' => $this->data->razaoSocial,
            'nomeFantasia' => $this->data->nomeFantasia,
            'cnpj' => $this->data->cnpj,
            'inscEstadual' => $this->data->inscEstadual,
            'inscMunicipal' => $this->data->inscMunicipal,
            'mostrarNoSite' => $this->data->mostrarNoSite,
            'descricao' => $this->data->descricao,
            'tipo' => $this->data->tipo,
            'tipoDeMoeda' => $this->data->tipoDeMoeda,
            'status' => $this->data->status,
            'restricao' => $this->data->restricao,
            'nomeContato' => $this->data->nomeContato,
            'telefone' => $this->data->telefone,
            'celular' => $this->data->celular,
            'emailContato' => $this->data->emailContato,
            'emailSecundario' => $this->data->emailSecundario,
            'site' => $this->data->site,
            'logradouro' => $this->data->logradouro,
            'numero' => $this->data->numero,
            'cep' => $this->data->cep,
            'complemento' => $this->data->complemento,
            'bairro' => $this->data->bairro,
            'cidade' => $this->data->cidade,
            'estado' => $this->data->estado,
            'regiao' => $this->data->regiao,
            'aceitaOrcamento' => $this->data->aceitaOrcamento,
            'aceitaVoucher' => $this->data->aceitaVoucher,
            'tipoOperacao' => $this->data->tipoOperacao,
            'categoriaId' => $this->data->categoriaId,
            'subcategoriaId' => $this->data->subcategoriaId,
            'taxaComissaoGerente' => $this->data->taxaComissaoGerente,
            'permissoesDoUsuario' => $this->data->permissoesDoUsuario,
            'tokenResetSenha' => $this->data->tokenResetSenha,
            'bloqueado' => $this->data->bloqueado,
        ]);
    }
}