<?php
namespace App\Models;

use CodeIgniter\Model;

class PembatalanModel extends Model
{
    protected $table      = 'pembatalan';
    protected $primaryKey = 'pembatalan_id';
    protected $useTimestamps = false;
    protected $allowedFields = ['no_invoice', 'no_dokumen', 'keterangan', 'user_id', 'tgl_pembatalan', 'surat_pembatalan', 'status','peb','feedback'];

    public function get($id = null)
    {
        if (!$id) {
            return $this->findAll();
        }

        return $this->where(['pembatalan_id' => $id])->first();
    }

    public function getGrafik($status, $date)
    {
        $this->where('status', $status);
        $this->like('tgl_pembatalan', $date, 'after');

        return count($this->findAll());
    }
}
