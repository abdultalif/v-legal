<?php

namespace App\Models;

use CodeIgniter\Model;

class KabupatenModel extends Model
{
    protected $table      = 'kabupaten';
    protected $primaryKey = 'kabupaten_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['kabupaten_id', 'kode_kabupaten', 'nama_kabupaten', 'status'];

    public function get($id = null)
    {
        $this->orderBy('kode_kabupaten', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['kabupaten_id' => $id])->first();
    }

    public function getDataByProvinsi($provinsi)
    {
        $this->orderBy('nama_kabupaten', 'asc');
        $this->where('LEFT(kode_kabupaten,2)', $provinsi);
        $this->where('status', 1);
        return $this->findAll();
    }
}