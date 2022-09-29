<?php

namespace App\Controllers;

class Pejabat extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Data Pejabat',
            'pejabat'  => $this->pejabat->get()
        ];

        return view('pejabat/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah Pejabat',
            'validation'    => $this->validation
        ];

        return view('pejabat/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_pejabat' => ['label' => 'Kode Pejabat', 'rules' => 'required'],
            'nama_pejabat' => ['label' => 'Nama Pejabat', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/pejabat/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = [
            'kode_pejabat'    => $this->request->getVar('kode_pejabat'),
            'nama_pejabat'    => $this->request->getVar('nama_pejabat'),
            'status'    => $this->request->getVar('status'),
        ];

        $this->pejabat->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/pejabat');
    }

    public function delete($id)
    {
        $this->pejabat->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/pejabat');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit Pejabat',
            'validation'    => $this->validation,
            'pejabat'      => $this->pejabat->get($id)
        ];

        return view('pejabat/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);
        
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/pejabat/edit/'.$input['pejabat_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->pejabat->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/pejabat');
    }
}
