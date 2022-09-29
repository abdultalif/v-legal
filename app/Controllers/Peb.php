<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Peb extends BaseController
{
    public function getList($clientId = null)
    {
        if (!in_array(userdata('role'), ['admin','superadmin'])) {
            $clientId = clientdata(userdata('user_id'))['client_id'];
        }

        $query = DataTables::use('pengajuan_sent')
                    ->select('client.nama_client as nama_client,sent_id,pengajuan.pengajuan_id as pengajuan_id,no_dokumen,pengajuan.no_invoice as no_invoice,tgl_sent')
                    ->select('(select count(*) from lampiran where jenis_file = "peb" and lampiran.pengajuan_id=pengajuan.pengajuan_id) as peb')
                    ->join('pengajuan', 'pengajuan.no_invoice=pengajuan_sent.no_invoice')
                    ->join('client', 'client.client_id=pengajuan.client_id')
                    ->where([
                        'pengajuan_sent.status' => 'terbit',
                        'pengajuan.status_dokumen' => 'diterima',
                        'pengajuan.client_id' => $clientId,
                    ])
                    ->make(true);

        return $this->response->setJSON($query);
    }

    public function index()
    {
        if (!in_array(userdata('role'), ['client'])) {
            return redirect()->to('/peb/data');
        }

        $clientId = clientdata(userdata('user_id'))['client_id'];

        $data = [
            'title'     => 'Data PEB',
        ];

        return view('peb/index', $data);
    }

    public function data()
    {
        if (!in_array(userdata('role'), ['admin','superadmin'])) {
            return redirect()->to('/home');
        }

        $data = [
            'title'     => 'Cek Status PEB',
            'client'    => $this->client->get()
        ];

        return view('peb/data', $data);
    }
}
