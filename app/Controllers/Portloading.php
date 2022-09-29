<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Portloading extends BaseController
{
    public function json()
    {
        $query = DataTables::use('port_loading')->make(true);
        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelabuhan Muat'
        ];

        return view('portloading/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah P.O.L',
            'validation'    => $this->validation
        ];

        return view('portloading/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_loading' => ['label' => 'Kode Provinsi', 'rules' => 'required'],
            'nama_loading' => ['label' => 'Nama Provinsi', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/portloading/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = [
            'kode_loading'    => $this->request->getVar('kode_loading'),
            'nama_loading'    => $this->request->getVar('nama_loading'),
            'status'    => $this->request->getVar('status'),
        ];

        $this->loading->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/portloading');
    }

    public function delete($id)
    {
        $this->loading->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/portloading');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);

        foreach ($checked as $id) {
            $this->loading->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/portloading');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit P.O.L',
            'validation'    => $this->validation,
            'portloading'      => $this->loading->get($id)
        ];

        return view('portloading/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/portloading/edit/'.$input['portloading_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->loading->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/portloading');
    }
}
