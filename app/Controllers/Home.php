<?php
namespace App\Controllers;

class Home extends BaseController
{
    private function _total()
    {
        $total = [
            'client'    => count($this->client->where(['client.status'=>1])->get()),
            'produk'    => count($this->produk->get()),
            'pengajuan' => count($this->pengajuan->get()),
            'buyer'     => count($this->buyer->get()),
        ];
        return $total;
    }

    public function index()
    {
        $data = [
            'title'     => 'Home',
            'total'     => $this->_total(),
        ];

        if (is_superadmin() || is_admin()) {
            $year = $this->request->getVar('tahun_grafik', FILTER_SANITIZE_STRING);
            if (!$year) {
                $year = date('Y');
            }

            $data['year'] = $year;
            $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            $data['diterima'] = [];
            $data['dibatalkan'] = [];

            foreach ($month as $m) {
                $date = $year. '-' . $m;
                $total_1 = (int) $this->terkirim->getGrafik('terbit', $date);
                $total_2 = (int) $this->pembatalan->getGrafik('sukses', $date);
                $data['diterima'][] = $total_1 == null ? 0 : $total_1;
                $data['dibatalkan'][] = $total_2 == null ? 0 : $total_2;
            }
        } else {
            $data['client'] = $this->client->getByUserId(userdata('user_id'));
        }

        return view('home', $data);
    }

    public function profile()
    {
        $data = [
            'title'     => 'My Profile',
            'validation'=> $this->validation
        ];

        return view('profile', $data);
    }

    private function _rules()
    {
        $id = userdata('user_id');
        $this->validation->setRules([
            'name' => ['label' => 'Nama', 'rules' => 'required'],
            'email' => ['label' => 'email', 'rules' => "required|is_unique[users.email,user_id,{$id}]"],
            'username' => ['label' => 'username', 'rules' => "required|is_unique[users.username,user_id,{$id}]"],
        ]);
    }

    public function save_profile()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/profile')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $input['user_id'] = userdata('user_id');

        if ($input['password']) {
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
        } else {
            unset($input['password']);
        }

        $file = $this->request->getFile('foto');

        if ($file->isValid() && ! $file->hasMoved()) {
            $path = FCPATH.'img/user/';

            $tipeFile = $file->getClientMimeType();
            $mimeType = [
                'image/jpeg','image/png', 'image/gif'
            ];

            if (in_array($tipeFile, $mimeType)) {
                $old = userdata('foto');
                if ($old != "default.png") {
                    if (is_file($path.$old)) {
                        unlink($path.$old);
                    }
                }
            } else {
                setToast('error', 'Tipe file foto tidak didukung');
                return redirect()->to('/profile');
            }

            $input['foto'] = $file->getRandomName();
            $file->move($path, $input['foto']);
        }

        $this->user->save($input);

        setToast('success', 'Profile berhasil disimpan');
        return redirect()->to('/profile');
    }
}
