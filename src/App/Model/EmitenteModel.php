<?php

namespace App\Model;

use Core\Model;

class EmitenteModel extends Model
{
    private $table = 'Emitente';
    
    public function create(array $data)
    {
        return $this->insert($this->table, $data);
    }
    
    public function getAll($page = 1, $itemsPerPage = 10, $orderBy = 'idEmitente')
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
        return $this->update($this->table, $data, 'idEmitente = :idEmitente', ['idEmitente' => $id]);
    }
    
    public function deleteById(int $id)
    {
        return $this->delete($this->table, 'idEmitente = :idEmitente', ['idEmitente' => $id]);
    }
}
