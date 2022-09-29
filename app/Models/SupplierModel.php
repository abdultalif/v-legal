<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table      = 'supplier';
    protected $primaryKey = 'supplier_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['supplier_id', 'negara_id', 'nama_supplier', 'alamat_supplier', 'user_id', 'status'];

    public function get($id = null)
    {
        $this->select('supplier.*,kode_negara,nama_negara');
        $this->join('negara', 'negara_id');
        $this->orderBy('nama_supplier', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['supplier_id' => $id])->first();
    }
}