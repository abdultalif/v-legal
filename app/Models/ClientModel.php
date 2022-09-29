<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'client';
    protected $primaryKey = 'client_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['user_id', 'nama_client', 'alamat_client', 'provinsi_id', 'kabupaten_id', 'status', 'telepon', 'fax', 'email', 'website', 'no_etpik', 'npwp', 'no_sertifikat', 'tgl_sertifikat', 'tgl_kadaluwarsa_sertifikat'];

    public function get($id = null)
    {
        $this->orderBy('nama_client', 'asc');
        $this->join('provinsi', 'provinsi_id', 'left');
        $this->join('kabupaten', 'kabupaten_id', 'left');
        
        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['client_id' => $id])->first();
    }

    public function getByUserId($id)
    {
        return $this->where(['user_id' => $id])->first();
    }
}
