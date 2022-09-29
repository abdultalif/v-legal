<?php

namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Negara extends BaseController
{
    public function json()
    {
        $query = DataTables::use('negara')->make(true);
        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Negara'
        ];

        return view('negara/data', $data);
    }
    public function add()
    {
        $data = [
            'title'         => 'Tambah Negara',
            'validation'    => $this->validation
        ];

        return view('negara/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_negara' => ['label' => 'Kode Negara', 'rules' => 'required|alpha|max_length[2]'],
            'nama_negara' => ['label' => 'Nama Negara', 'rules' => 'required'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);
        $input['kode_negara'] = strtoupper($input['kode_negara']);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/negara/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->negara->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/negara');
    }

    public function delete($id)
    {
        $this->negara->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/negara');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);
        
        foreach ($checked as $id) {
            $this->negara->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/negara');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit Negara',
            'validation'    => $this->validation,
            'negara'      => $this->negara->get($id)
        ];

        return view('negara/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);
        
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/negara/edit/'.$input['negara_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->negara->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/negara');
    }
}
