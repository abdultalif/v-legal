<?php

namespace App\Models;

use CodeIgniter\Model;

class MatauangModel extends Model
{
    protected $table      = 'mata_uang';
    protected $primaryKey = 'uang_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['uang_id', 'iso_4217', 'nama_uang'];

    public function get($id = null)
    {
        $this->orderBy('iso_4217', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['uang_id' => $id])->first();
    }
}