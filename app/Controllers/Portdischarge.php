<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class Portdischarge extends BaseController
{
    public function json()
    {
        $query = DataTables::use('port_discharge')->make(true);

        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Pelabuhan Bongkar',
        ];

        return view('portdischarge/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah P.O.D',
            'validation'    => $this->validation
        ];

        return view('portdischarge/add', $data);
    }

    private function _rules()
    {
        $this->validation->setRules([
            'kode_discharge' => ['label' => 'Kode Provinsi', 'rules' => 'required'],
            'nama_discharge' => ['label' => 'Nama Provinsi', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/portdischarge/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = [
            'kode_discharge'    => $this->request->getVar('kode_discharge'),
            'nama_discharge'    => $this->request->getVar('nama_discharge'),
            'status'            => $this->request->getVar('status'),
        ];

        $this->discharge->save($input);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/portdischarge');
    }

    public function delete($id)
    {
        $this->discharge->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/portdischarge');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);

        foreach ($checked as $id) {
            $this->discharge->delete($id);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/portdischarge');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit P.O.D',
            'validation'    => $this->validation,
            'portdischarge'      => $this->discharge->get($id)
        ];

        return view('portdischarge/edit', $data);
    }

    public function update()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/portdischarge/edit/'.$input['portdischarge_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        $this->discharge->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/portdischarge');
    }
}
