<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'produk_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['produk_id', 'kode_hs', 'nama_produk', 'foto_produk', 'user_id', 'status'];

    public function get($id = null)
    {
        $this->orderBy('kode_hs', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['produk_id' => $id])->first();
    }
}