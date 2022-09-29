<?php



namespace App\Controllers;



use Irsyadulibad\DataTables\DataTables;



class Jenis extends BaseController

{

    public function json()

    {

        $query = DataTables::use('jenis_kayu')

            ->make(true);

        return $this->response->setJSON($query);
    }



    public function index()

    {

        $data = [

            'title'     => 'Data Jenis Kayu'

        ];



        return view('jenis/data', $data);
    }



    public function add()

    {

        $data = [

            'title'         => 'Tambah Jenis Kayu',

            'validation'    => $this->validation

        ];



        return view('jenis/add', $data);
    }



    private function _rules()

    {

        $this->validation->setRules([

            'nama_jenis' => ['label' => 'Nama Jenis', 'rules' => 'required'],

        ]);
    }



    public function save()

    {

        $this->_rules();



        if (!$this->validation->withRequest($this->request)->run()) {

            return redirect()

                ->to('/jenis/add')

                ->withInput()

                ->with('validation', $this->validation);
        }



        $input = [

            'nama_jenis'    => $this->request->getVar('nama_jenis'),

        ];



        $this->kayu->save($input);



        setToast('success', "Data berhasil disimpan");

        return redirect()->to('/jenis');
    }



    public function delete($id)

    {

        $this->kayu->delete($id);



        setToast('success', "Data berhasil dihapus");

        return redirect()->to('/jenis');
    }



    public function edit($id)

    {

        $data = [

            'title'         => 'Edit Jenis',

            'validation'    => $this->validation,

            'jenis'         => $this->kayu->get($id)

        ];



        return view('jenis/edit', $data);
    }



    public function update()

    {

        $this->_rules();



        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);

        unset($input['csrf_test_name']);



        if (!$this->validation->withRequest($this->request)->run()) {

            return redirect()

                ->to('/jenis/edit/' . $input['jenis_id'])

                ->withInput()

                ->with('validation', $this->validation);
        }



        $this->kayu->save($input);



        setToast('success', "Data berhasil diupdate");

        return redirect()->to('/jenis');
    }
}
