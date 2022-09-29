<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Produk extends BaseController
{
    public function json()
    {
        $current_user = userdata('user_id');
        $role = userdata('role');

        if ($role != "superadmin") {
            $query = DataTables::use('produk')
                        ->select('produk.*,client.nama_client as nama_client')
                        ->join('users','user_id', 'left')
                        ->join('client', 'user_id', 'left')
                        ->where(['produk.user_id'=>$current_user])
                        ->make(true);
        } else {
            $query = DataTables::use('produk')
                        ->select('produk.*,client.nama_client as nama_client')
                        ->join('users','user_id', 'left')
                        ->join('client', 'user_id', 'left')
                        ->make(true);
        }

        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Produk'
        ];

        return view('produk/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah Produk',
            'validation'    => $this->validation
        ];

        return view('produk/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_hs' => ['label' => 'Kode HS', 'rules' => 'required|numeric|min_length[8]'],
            'nama_produk' => ['label' => 'Nama Produk', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/produk/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $file = $this->request->getFile('foto_produk');
        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
    
        if ($file->isValid() && ! $file->hasMoved()) {
            $path = FCPATH.'uploads/produk';
            $input['foto_produk'] = $file->getRandomName();
            $file->move($path, $input['foto_produk']);
        }

        $this->produk->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/produk');
    }

    private function _delete_img($id)
    {
        $path = FCPATH.'uploads/produk/';
        $img = $this->produk->get($id)['foto_produk'];
        $foto = $path.$img;

        if (is_file($foto)) {
            return unlink($foto);
        }
    }

    public function delete($id)
    {
        if ($this->request->getMethod() !== 'delete') {
            return redirect()->to('/produk');
        }

        $this->_delete_img($id);
        $this->produk->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/produk');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);
        
        foreach ($checked as $id) {
            $this->produk->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/produk');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit Produk',
            'validation'    => $this->validation,
            'produk'      => $this->produk->get($id)
        ];

        return view('produk/edit', $data);
    }

    public function update()
    {
        $this->_rules();
        
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/produk/edit/'.$input['produk_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }
        
        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $file = $this->request->getFile('foto_produk');

        if ($file->isValid() && !$file->hasMoved()) {
            $path = FCPATH.'uploads/produk';
            $this->_delete_img($input['produk_id']);
            $input['foto_produk'] = $file->getRandomName();
            $file->move($path, $input['foto_produk']);
        }

        $this->produk->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/produk');
    }
}