<?php

namespace App\Models;

use CodeIgniter\Model;

class LmkModel extends Model
{
    protected $table      = 'lmk';
    protected $primaryKey = 'lmk_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['tgl_lmk','file_lmk','ket_lmk', 'bulan_lmk', 'tahun_lmk', 'client_id'];

    public function get($id = null)
    {
        $this->join('client', 'client_id', 'left');
        $this->orderBy('tgl_lmk', 'desc');

        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['lmk_id' => $id])->first();
    }

    public function cekLMKBulanan($client_id, $bln, $thn)
    {
        // $bln = date('n', strtotime($bln));
        // $thn = date('Y', strtotime($bln));
        
        // $this->like('tgl_lmk', $bln, 'after');
        $this->where(['client_id'=>$client_id, 'bulan_lmk'=>$bln, 'tahun_lmk'=>$thn]);

        return $this->findAll();
    }
}
