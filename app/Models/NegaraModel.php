<?php

namespace App\Models;

use CodeIgniter\Model;

class NegaraModel extends Model
{
    protected $table      = 'negara';
    protected $primaryKey = 'negara_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['negara_id', 'kode_negara', 'nama_negara', 'status'];

    public function get($id = null, $actived_only = false)
    {
        $this->orderBy('kode_negara', 'asc');

        if ($actived_only) {
            $this->where('status', 1);
        }

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['negara_id' => $id])->first();
    }
}