<?php

namespace App\Models;

use CodeIgniter\Model;

class PortloadingModel extends Model
{
    protected $table      = 'port_loading';
    protected $primaryKey = 'loading_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['loading_id', 'kode_loading', 'nama_loading', 'status'];

    public function get($id = null)
    {
        $this->orderBy('kode_loading', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['loading_id' => $id])->first();
    }
}