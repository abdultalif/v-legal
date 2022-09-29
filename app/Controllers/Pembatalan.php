<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Pembatalan extends BaseController
{
    public function json()
    {
        if (is_admin() || is_superadmin()) {
            $query = DataTables::use('pembatalan')
                ->select('pembatalan_id,no_dokumen,no_invoice,keterangan,pembatalan.status,pembatalan.surat_pembatalan,tgl_pembatalan,user_id,users.name as user,peb,feedback')
                ->join('users', 'user_id', 'left')
                ->make(true);
        } else {
            $query = DataTables::use('pembatalan')
                ->select('pembatalan_id,no_dokumen,no_invoice,keterangan,pembatalan.status,pembatalan.surat_pembatalan,tgl_pembatalan,user_id,users.name as user,peb,feedback')
                ->join('users', 'user_id', 'left')
                ->where(['user_id'=>userdata('user_id')])
                ->make(true);
        }

        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title' => 'List Pembatalan',
        ];

        return view('pembatalan/index', $data);
    }

    public function add($no_dokumen = null)
    {
        $data = [
            'title' => 'Form Pembatalan',
            'no_dokumen' => $no_dokumen,
            'validation' => $this->validation
        ];

        return view('pembatalan/add', $data);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Form Pembatalan',
            'pembatalan' => $this->pembatalan->get($id),
            'validation' => $this->validation
        ];

        return view('pembatalan/edit', $data);
    }

    public function save()
    {
        $this->validation->setRules([
            'no_dokumen' => ['label' => 'Nomor Dokumen', 'rules' => 'required'],
            'no_invoice' => ['label' => 'Nomor Invoice', 'rules' => 'required'],
            'keterangan' => ['label' => 'Keterangan', 'rules' => 'required'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validation);
        }

        $file   = $this->request->getFiles();
        $sp = $file['surat_pembatalan'];
        $peb = $file['peb'];

        $input  = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        if (array_key_exists('pembatalan_id', $input)) {
            $item = $this->pembatalan->get($input['pembatalan_id']);
            $input['status'] = 'draft';
        } else {
            $input['user_id'] = userdata('user_id');
            $input['tgl_pembatalan'] = date('Y-m-d H:i:s');
        }

        if ($sp->isValid()) {
            $path = FCPATH.'uploads/pembatalan';
            $input['surat_pembatalan'] = $sp->getRandomName();

            if (array_key_exists('pembatalan_id', $input)) {
                if (is_file($path.'/'.$item['surat_pembatalan'])) {
                    unlink($path.'/'.$item['surat_pembatalan']);
                }
            }

            $sp->move($path, $input['surat_pembatalan']);
        } else {
            if (!array_key_exists('pembatalan_id', $input)) {
                setToast('error', "Silahkan mengupload surat pembatalan.");
                return redirect()->back();
            }
        }

        if ($peb->isValid()) {
            $path_peb = FCPATH.'uploads/pembatalan/peb';
            $input['peb'] = $peb->getRandomName();
            if (array_key_exists('pembatalan_id', $input)) {
                if (is_file($path_peb.'/'.$item['peb'])) {
                    unlink($path_peb.'/'.$item['peb']);
                }
            }
            $peb->move($path_peb, $input['peb']);
        }

        $this->pembatalan->save($input);

        setToast('success', "Data berhasil dikirim");
        return redirect()->to('/pembatalan');
    }

    public function reject()
    {
        $data['pembatalan_id'] = $this->request->getVar('pembatalan_id');
        $data['feedback'] = $this->request->getVar('feedback');
        $data['status'] = 'gagal';

        $this->pembatalan->save($data);
        setToast('success', "Data berhasil direject");
        return redirect()->back();
    }

    public function delete($id)
    {
        if ($this->request->getMethod() !== 'delete') {
            return redirect()->back();
        }

        $path = FCPATH.'uploads/pembatalan/';
        $file = $this->pembatalan->get($id)['surat_pembatalan'];
        $peb = $this->pembatalan->get($id)['peb'];

        $surat = $path.$file;

        if (is_file($surat)) {
            unlink($surat);
        }

        if (is_file($path.'peb/'.$peb)) {
            unlink($path.'peb/'.$peb);
        }

        $this->pembatalan->delete($id);

        setToast('success', 'Data berhasil dihapus');
        return redirect()->back();
    }
}
