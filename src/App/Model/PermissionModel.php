<?php

namespace App\Model;

use Core\Model;

class PermissionModel extends Model
{
    private $table = 'permissions';
    
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
    
    public function updateByRuleAndResource(int $rule_id, int $resource_id, array $data)
    {
        return $this->update(
            $this->table,
            $data,
            'rule_id = :rule_id AND resource_id = :resource_id',
            ['rule_id' => $rule_id, 'resource_id' => $resource_id]
        );
    }
    
    public function deleteByRuleAndResource(int $rule_id, int $resource_id)
    {
        return $this->delete($this->table, 'rule_id = :rule_id AND resource_id = :resource_id', ['rule_id' => $rule_id, 'resource_id' => $resource_id]);
    }
}
