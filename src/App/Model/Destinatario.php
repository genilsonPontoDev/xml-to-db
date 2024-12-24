<?php

namespace App\Models;

use Core\Model;

class Destinatario extends Model
{
    private $idDestinatario;
    private $nome;
    private $cpf;
    private $logradouro;
    private $numero;
    private $bairro;
    private $cidade;
    private $estado;
    private $cep;

    public function __construct($idDestinatario = null, $nome = '', $cpf = '', $logradouro = '', $numero = '', $bairro = '', $cidade = '', $estado = '', $cep = '')
    {
        parent::__construct();
        if ($idDestinatario !== null) {
            $this->idDestinatario = $idDestinatario;
        }
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->cep = $cep;
    }

    // Método para inserir um novo Destinatario
    public function save()
    {
        try {
            $data = [
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'logradouro' => $this->logradouro,
                'numero' => $this->numero,
                'bairro' => $this->bairro,
                'cidade' => $this->cidade,
                'estado' => $this->estado,
                'cep' => $this->cep
            ];

            if ($this->idDestinatario) {
                // Atualizar um Destinatario existente
                return $this->update('Destinatario', $data, 'idDestinatario = :idDestinatario', ['idDestinatario' => $this->idDestinatario]);
            } else {
                // Inserir um novo Destinatario
                return $this->insert('Destinatario', $data);
            }
        } catch (\Exception $e) {
            throw new \Exception("Erro ao salvar Destinatario: " . $e->getMessage());
        }
    }

    // Método para buscar um Destinatario por ID
    public function findById($idDestinatario)
    {
        try {
            return $this->find('Destinatario', 'idDestinatario = :idDestinatario', ['idDestinatario' => $idDestinatario]);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao buscar Destinatario: " . $e->getMessage());
        }
    }

    // Método para listar todos os Destinatarios
    public function findAll($page = 1, $itemsPerPage = 100)
    {
        try {
            return $this->paginate('Destinatario', 'idDestinatario', $page, $itemsPerPage);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao listar Destinatarios: " . $e->getMessage());
        }
    }

    // Método para excluir um Destinatario
    public function deleteById($idDestinatario)
    {
        try {
            return $this->delete('Destinatario', 'idDestinatario = :idDestinatario', ['idDestinatario' => $idDestinatario]);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao excluir Destinatario: " . $e->getMessage());
        }
    }
}
