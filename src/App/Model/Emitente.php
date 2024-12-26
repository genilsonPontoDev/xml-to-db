<?php

namespace App\Model;

use Core\Model;

class Emitente extends Model
{
    private $idEmitente;
    private $nome;
    private $cnpj;
    private $logradouro;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    public function __construct($idEmitente = null, $nome = '', $cnpj = '', $logradouro = '', $numero = '', $bairro = '', $cidade = '', $estado = '', $cep = '')
    {
        parent::__construct();
        if ($idEmitente !== null) {
            $this->idEmitente = $idEmitente;
        }
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
    }

    // Método para inserir ou atualizar um Emitente
    public function save($dados = [])
    {
        try {
            // Se os dados não forem passados, usa os dados da própria instância
            if (empty($dados)) {
                $dados = [
                    'nome' => $this->nome,
                    'cnpj' => $this->cnpj,
                    'logradouro' => $this->logradouro,
                    'numero' => $this->numero,
                    'bairro' => $this->bairro,
                    'cidade' => $this->cidade,
                    'estado' => $this->estado,
                    'cep' => $this->cep
                ];
            }

            // Se existe um idEmitente, atualiza, caso contrário insere um novo
            if ($this->idEmitente) {
                return $this->update('Emitente', $dados, 'idEmitente = :idEmitente', ['idEmitente' => $this->idEmitente]);
            } else {                
                return $this->insert('Emitente', $dados);
            }
        } catch (\Exception $e) {
            throw new \Exception("Erro ao salvar Emitente: " . $e->getMessage());
        }
    }

    // Método para buscar um Emitente por ID
    public function findById($idEmitente)
    {
        try {
            return $this->find('Emitente', 'idEmitente = :idEmitente', ['idEmitente' => $idEmitente]);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao buscar Emitente: " . $e->getMessage());
        }
    }

    // Método para listar todos os Emitentes
    public function findAll($page = 1, $itemsPerPage = 100)
    {
        try {
            return $this->paginate('Emitente', 'idEmitente', $page, $itemsPerPage);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao listar Emitentes: " . $e->getMessage());
        }
    }

    // Método para excluir um Emitente
    public function deleteById($idEmitente)
    {
        try {
            return $this->delete('Emitente', 'idEmitente = :idEmitente', ['idEmitente' => $idEmitente]);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao excluir Emitente: " . $e->getMessage());
        }
    }
}
