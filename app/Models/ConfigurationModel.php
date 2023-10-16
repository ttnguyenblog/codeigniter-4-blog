<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigurationModel extends Model
{
    protected $table = "configuration";
    protected $primaryKey = "id";
    protected $allowedFields = ['configuration_name', 'configuration_value'];

    
    public function getData($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where($parameter);
        $query = $builder->get();
        return $query->getRowArray();
    }

    
    public function updateData($data)
    {
        helper("global_function_helper");
        $builder = $this->table($this->table);
        foreach ($data as $key => $value) {
            $data[$key] = purify($value);
        }
        if ($builder->save($data)) {
            return true;
        } else {
            return false;
        }
    }
}