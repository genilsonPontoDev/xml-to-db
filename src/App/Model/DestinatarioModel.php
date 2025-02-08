<?php

namespace App\Model;

use Core\Model;

class DestinatarioModel extends Model
{
    private $table = 'Destinatario';
    
    public function create(array $data)
    {
        return $this->insert($this->table, $data);
    }
    
    public function getAll($page = 1, $itemsPerPage = 10, $orderBy = 'idDestinatario')
    {
        return $this->paginate($this->table, $orderBy, $page, $itemsPerPage);
    }
    
    public function findBy(array $conditions)
    {
        $where = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        return $this->select($this->table, $where, $conditions);
    }
    
    public function findOneBy(array $conditions)
    {
        $where = implode(' AND ', array_map(fn($key) => "$key = :$key", array_keys($conditions)));
        return $this->find($this->table, $where, $conditions);
    }
    
    public function updateById(int $id, array $data)
    {
        return $this->update($this->table, $data, 'idDestinatario = :idDestinatario', ['idDestinatario' => $id]);
    }
    
    public function deleteById(int $id)
    {
        return $this->delete($this->table, 'idDestinatario = :idDestinatario', ['idDestinatario' => $id]);
    }
}
