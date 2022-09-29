<?php

namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Provinsi extends BaseController
{
    public function json()
    {
        $query = DataTables::use('provinsi')->make(true);
        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Provinsi',
        ];

        return view('provinsi/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah Provinsi',
            'validation'    => $this->validation
        ];

        return view('provinsi/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_provinsi' => ['label' => 'Kode Provinsi', 'rules' => 'required|numeric'],
            'nama_provinsi' => ['label' => 'Nama Provinsi', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/provinsi/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = [
            'kode_provinsi'    => $this->request->getVar('kode_provinsi'),
            'nama_provinsi'    => $this->request->getVar('nama_provinsi'),
            'status'    => $this->request->getVar('status'),
        ];

        $this->provinsi->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/provinsi');
    }

    public function delete($id)
    {
        $this->provinsi->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/provinsi');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);
        
        foreach ($checked as $id) {
            $this->provinsi->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/provinsi');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit Provinsi',
            'validation'    => $this->validation,
            'provinsi'      => $this->provinsi->get($id)
        ];

        return view('provinsi/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);
        
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/provinsi/edit/'.$input['provinsi_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->provinsi->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/provinsi');
    }
}
