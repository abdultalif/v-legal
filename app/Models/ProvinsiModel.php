<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinsiModel extends Model
{
    protected $table      = 'provinsi';
    protected $primaryKey = 'provinsi_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['provinsi_id', 'kode_provinsi', 'nama_provinsi', 'status'];

    public function get($id = null, $sort = false)
    {
        if ($sort) {
            $this->orderBy('nama_provinsi', 'asc');
        }

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['provinsi_id' => $id])->first();
    }
}