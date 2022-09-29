<?php

namespace App\Models;

use CodeIgniter\Model;

class BuyerModel extends Model
{
    protected $table      = 'buyer';
    protected $primaryKey = 'buyer_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['buyer_id', 'negara_id', 'nama_buyer', 'alamat_buyer', 'user_id', 'status'];

    public function get($id = null)
    {
        $this->select('buyer.*,kode_negara,nama_negara');
        $this->join('negara', 'negara_id');
        $this->orderBy('nama_buyer', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['buyer_id' => $id])->first();
    }
}