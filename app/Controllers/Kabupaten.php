<?php

namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Kabupaten extends BaseController
{
    public function json()
    {
        $query = DataTables::use('kabupaten')->make(true);
        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Kabupaten'
        ];

        return view('kabupaten/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah Kabupaten',
            'validation'    => $this->validation
        ];

        return view('kabupaten/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_kabupaten' => ['label' => 'Kode Kabupaten', 'rules' => 'required|numeric'],
            'nama_kabupaten' => ['label' => 'Nama Kabupaten', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/kabupaten/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = [
            'kode_kabupaten'    => $this->request->getVar('kode_kabupaten'),
            'nama_kabupaten'    => $this->request->getVar('nama_kabupaten'),
            'status'    => $this->request->getVar('status'),
        ];

        $this->kabupaten->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/kabupaten');
    }

    public function delete($id)
    {
        $this->kabupaten->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/kabupaten');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);
        
        foreach ($checked as $id) {
            $this->kabupaten->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/kabupaten');
    }
    
    public function edit($id)
    {
        $data = [
            'title'         => 'Edit Kabupaten',
            'validation'    => $this->validation,
            'kabupaten'      => $this->kabupaten->get($id)
        ];

        return view('kabupaten/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);
        
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/kabupaten/edit/'.$input['kabupaten_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->kabupaten->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/kabupaten');
    }
}
