<?php

namespace App\Models;

use CodeIgniter\Model;

class LampiranModel extends Model
{
    protected $table      = 'lampiran';
    protected $primaryKey = 'lampiran_id';
    protected $useTimestamps = false;

    protected $allowedFields = ['lampiran_id','pengajuan_id','jenis_file','tgl_lampiran','file_lampiran', 'size_file'];

    public function get($id)
    {
        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['lampiran_id' => $id])->first();
    }

    public function getJenisFile($id)
    {
        $query = $this->select('jenis_file')->where(['pengajuan_id'=>$id])->findAll();
        $jenis = [];

        foreach ($query as $row) {
            $jenis[] = $row['jenis_file'];
        }

        return $jenis;
    }

    public function getIdByPengajuan($id)
    {
        return $this->where(['pengajuan_id'=>$id])->findAll();
    }

    public function getFileKosong($id)
    {
        $jenis = $this->getJenisFile($id);
        $required = ['permohonan','invoice','packing_list'];
        return array_diff($required, $jenis);
    }
}
