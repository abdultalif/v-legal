<?php

namespace App\Models;

use CodeIgniter\Model;

class PortdischargeModel extends Model
{
    protected $table      = 'port_discharge';
    protected $primaryKey = 'discharge_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['discharge_id', 'kode_discharge', 'nama_discharge', 'status'];

    public function get($id = null)
    {
        $this->orderBy('kode_discharge', 'asc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['discharge_id' => $id])->first();
    }

    public function getDischargeByCountry($kode, $search)
    {
        $this->select("discharge_id as id, CONCAT(kode_discharge,' - ',nama_discharge) as text");
        $this->where(['LEFT(kode_discharge,2)'=>$kode]);
        $this->like('nama_discharge', $search);
        return $this->findAll();
    }
}
