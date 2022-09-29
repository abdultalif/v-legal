<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table      = 'pengajuan';
    protected $primaryKey = 'pengajuan_id';
    protected $useTimestamps = true;

    protected $allowedFields = ['pengajuan_id','client_id','buyer_id','negara_id','mata_uang','loading_id','discharge_id','keterangan','no_invoice','tgl_invoice','alat_angkut','tgl_shipment','lokasi_stuffing','status_dokumen','keterangan_status', 'reviewer'];

    public function get($id = null)
    {
        $this->join('client', 'client_id', 'left');
        $this->join('negara', 'negara_id', 'left');
        $this->join('buyer', 'buyer_id', 'left');
        $this->join('port_loading', 'loading_id', 'left');
        $this->join('port_discharge', 'discharge_id', 'left');

        if (!$id) {
            return $this->findAll();
        }
        
        return $this->where(['pengajuan_id'=>$id])->first();
    }
    
    public function detail($id)
    {
        $this->select('pengajuan_id,npwp,nama_provinsi,nama_client,no_sertifikat,alamat_client,nama_kabupaten,no_etpik');
        $this->select('buyer_id,nama_buyer,alamat_buyer,kode_negara,nama_negara,kode_loading,nama_loading,kode_discharge,nama_discharge');
        $this->select('no_invoice,tgl_invoice,alat_angkut,keterangan,tgl_shipment,lokasi_stuffing,status_dokumen');
        $this->join('client', 'client_id', 'left');
        $this->join('negara', 'negara.negara_id=pengajuan.negara_id', 'left');
        $this->join('buyer', 'buyer_id', 'left');
        $this->join('provinsi', 'provinsi.provinsi_id=client.provinsi_id');
        $this->join('kabupaten', 'kabupaten.kabupaten_id=client.kabupaten_id');
        $this->join('port_loading', 'loading_id', 'left');
        $this->join('port_discharge', 'discharge_id', 'left');

        return $this->where(['pengajuan_id'=>$id])->first();
    }

    public function sendDetail($id)
    {
        $this->select('pengajuan_id,kode_loading,kode_negara,kode_discharge,client_id');
        $this->select('buyer.*');
        $this->select('no_invoice,tgl_invoice,alat_angkut,keterangan,lokasi_stuffing');
        $this->join('buyer', 'buyer_id', 'left');
        $this->join('port_loading', 'loading_id', 'left');
        $this->join('negara', 'negara.negara_id=pengajuan.negara_id', 'left');
        $this->join('port_discharge', 'discharge_id', 'left');

        return $this->where(['pengajuan_id'=>$id])->first();
    }

    public function getLaporan($query)
    {
        if ($query['tgl_awal'] && $query['tgl_akhir']) {
            $this->select('pengajuan.updated_at,client.nama_client,pengajuan.no_invoice,pengajuan.status_dokumen,pembatalan.keterangan,users.name');
            $this->whereNotIn('status_dokumen', ['draft','dikirim','ditolak']);
            
            if ($query['status_dokumen']) {
                $this->where('status_dokumen', $query['status_dokumen']);
            }
            
            $this->where(['pengajuan.updated_at >=' => $query['tgl_awal']]);
            $this->where(['pengajuan.updated_at <=' => $query['tgl_akhir']]);

            if ($query['client_id']) {
                $this->where(['client_id'=>$query['client_id']]);
            }

            if ($query['reviewer']) {
                $this->where(['reviewer'=>$query['reviewer']]);
            }

            $this->join('pembatalan', 'no_invoice', 'left');
            $this->join('client', 'client_id', 'left');
            $this->join('users', 'pengajuan.reviewer=users.user_id', 'left');
            
            $this->orderBy('client.nama_client', 'asc');
            
            return $this->findAll();
        } else {
            return [];
        }
    }
}
