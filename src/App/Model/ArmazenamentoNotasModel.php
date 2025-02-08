<?php

namespace App\Mode;

use Core\Model;

class ArmazenamentoNotasModel extends Model
{
    private $table = 'armazenamento_notas_dist_d_fes';
    
    public function create(array $data)
    {
        return $this->insert($this->table, $data);
    }
    
    public function getAll($page = 1, $itemsPerPage = 10, $orderBy = 'id')
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
        return $this->update($this->table, $data, 'id = :id', ['id' => $id]);
    }
    
    public function setManifestadaById(int $id, bool $manifestada)
    {
        return $this->update($this->table, ['manifestada' => $manifestada], 'id = :id', ['id' => $id]);
    }
    
    public function deleteById(int $id)
    {
        return $this->delete($this->table, 'id = :id', ['id' => $id]);
    }
}
