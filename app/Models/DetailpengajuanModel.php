<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailpengajuanModel extends Model
{
    protected $table      = 'detail_pengajuan';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    
    protected $allowedFields = ['pengajuan_id', 'produk_id', 'negara_id', 'jumlah', 'volume','berat','nilai','jenis_id','negara_id'];

    public function get($id)
    {
        $this->select('id,pengajuan_id,kode_hs,nama_produk,volume,berat,jumlah,nilai,mata_uang,jenis_id,detail_pengajuan.negara_id');
        $this->join('produk', 'produk_id', 'left');
        $this->join('pengajuan', 'pengajuan_id', 'left');

        return $this->where(['pengajuan_id'=>$id])->findAll();
    }

    public function getTotal($id)
    {
        $this->select('SUM(berat) as total_berat');
        $this->select('SUM(volume) as total_volume');
        $this->select('SUM(jumlah) as total_jumlah');
        $this->select('SUM(nilai) as total_nilai');
        return $this->where(['pengajuan_id'=>$id])->first();
    }

    public function getByPengajuanId($id)
    {
        return $this->where(['pengajuan_id' => $id])->findAll();
    }
}
