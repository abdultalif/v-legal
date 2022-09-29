<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisModel extends Model
{
    protected $table      = 'jenis_kayu';
    protected $primaryKey = 'jenis_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['jenis_id', 'nama_jenis'];

    public function get($id = null)
    {
        $this->orderBy('nama_jenis', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['jenis_id' => $id])->first();
    }
}
