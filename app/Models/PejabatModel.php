<?php

namespace App\Models;

use CodeIgniter\Model;

class PejabatModel extends Model
{
    protected $table      = 'pejabat';
    protected $primaryKey = 'pejabat_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['pejabat_id', 'kode_pejabat', 'nama_pejabat', 'status'];

    public function get($id = null)
    {
        $this->orderBy('kode_pejabat', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['pejabat_id' => $id])->first();
    }
}