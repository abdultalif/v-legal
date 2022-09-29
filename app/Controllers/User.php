<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;

class User extends BaseController
{
    public function json()
    {
        $query = DataTables::use('users')
                ->hideColumns(['password'])
                ->make(true);

        return $this->response->setJSON($query);
    }

    public function index()
    {
        $data = [
            'title'     => 'Data User'
        ];

        return view('user/data', $data);
    }

    public function add()
    {
        $data = [
            'title'         => 'Tambah User',
            'validation'    => $this->validation
        ];

        return view('user/add', $data);
    }

    public function save()
    {
        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|is_unique[users.username]'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'name' => ['label' => 'Nama', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'role' => ['label' => 'Role', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/user/add')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        unset($input['csrf_test_name']);

        $this->user->save($input);
        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/user');
    }

    public function delete($id)
    {
        if ($this->request->getMethod() !== 'delete') {
            return redirect()->to('/user');
        }

        $this->user->delete($id);

        $client = $this->client->getByUserId($id);
        if ($client) {
            $this->client->delete($client['client_id']);
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/user');
    }

    public function multi_delete()
    {
        $checked = $this->request->getVar('checked', FILTER_SANITIZE_STRING);

        foreach ($checked as $id) {
            $this->user->delete($id);

            $client = $this->client->getByUserId($id);
            if ($client) {
                $this->client->delete($client['client_id']);
            }
        }

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/user');
    }

    public function edit($id)
    {
        $data = [
            'title'         => 'Edit User',
            'user'          => $this->user->get($id),
            'validation'    => $this->validation
        ];

        return view('user/edit', $data);
    }

    public function update()
    {
        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required|is_unique[users.username,user_id,{user_id}]'],
            'name' => ['label' => 'Nama', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'role' => ['label' => 'Role', 'rules' => 'required'],
            'status' => ['label' => 'Status', 'rules' => 'required|numeric'],
        ]);

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        unset($input['csrf_test_name']);

        if (empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        }

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/user/edit/'.$input['user_id'])
                ->withInput()
                ->with('validation', $this->validation);
        }

        if (is_admin()) {
            if ($input['role']=="client") {
                $updateClient = [
                    'client_id' => clientdata($input['user_id']),
                    'status'=>$input['status']
                ];
                $this->client->save($updateClient);
            }
        }

        $this->user->save($input);

        setToast('success', "Data berhasil diupdate");
        return redirect()->to('/user');
    }
}
