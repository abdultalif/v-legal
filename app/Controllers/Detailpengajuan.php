<?php
namespace App\Controllers;

use CodeIgniter\I18n\Time;
use Irsyadulibad\DataTables\DataTables;

class Detailpengajuan extends BaseController
{
    public function index()
    {
        return redirect()->to('pengajuan');
    }

    public function detail($id)
    {
        $pengajuan = $this->pengajuan->get($id);

        if (!$pengajuan) {
            return redirect()->to('/pengajuan');
        } else {
            $currentClientId = clientdata(userdata('user_id'))['client_id'];
            if ($pengajuan['client_id'] != $currentClientId) {
                return redirect()->to('/pengajuan');
            }
        }

        $data = [
            'title'         => 'Detail Pengajuan',
            'validation'    => $this->validation,
            'detail'        => $pengajuan,
            'list_detail'   => $this->detail->get($id),
            'total'         => $this->detail->getTotal($id),
            'jenis_kayu'    => $this->kayu,
            'negara'        => $this->negara,
        ];

        return view('pengajuan/detail/data', $data);
    }

    public function add($id)
    {
        $pengajuan = $this->pengajuan->get($id);

        if (!$pengajuan) {
            return redirect()->to('/pengajuan');
        } else {
            $currentClientId = clientdata(userdata('user_id'))['client_id'];
            if ($pengajuan['client_id'] != $currentClientId) {
                return redirect()->to('/pengajuan');
            }
        }

        $data = [
            'title'         => 'Tambah Detail Pengajuan',
            'validation'    => $this->validation,
            'detail'        => $pengajuan,
            'produk'        => $this->produk->get(),
            // 'produk'        => $this->produk->where(['status'=>1,'user_id'=>userdata('user_id')])->get(),
            'kayu'          => $this->kayu->get(),
            'getNegara'     => $this->negara->get(),
        ];

        return view('pengajuan/detail/add', $data);
    }

    public function get($id)
    {
        $query = $this->detail->where(['id'=>$id])->first();

        return $this->response->setJSON($query);
    }

    public function edit($id)
    {
        $detail = $this->detail->where(['id'=>$id])->first();
        if (!$detail) {
            return redirect()->to('/pengajuan');
        }

        $pengajuan = $this->pengajuan->get($detail['pengajuan_id']);

        if (!$pengajuan) {
            return redirect()->to('/pengajuan');
        } else {
            $currentClientId = clientdata(userdata('user_id'))['client_id'];
            if ($pengajuan['client_id'] != $currentClientId) {
                return redirect()->to('/pengajuan');
            }
        }

        $data = [
            'title'         => 'Edit Detail Pengajuan',
            'validation'    => $this->validation,
            'pengajuan'     => $pengajuan,
            'detail'        => $detail,
            'produk'        => $this->produk->get(),
            // 'produk'     => $this->produk->where(['status'=>1,'user_id'=>userdata('user_id')])->get(),
            'kayu'          => $this->kayu->get(),
            'getNegara'     => $this->negara->get(),
            'jenis_kayu'    => $this->kayu,
            'negara'        => $this->negara,
        ];

        return view('pengajuan/detail/edit', $data);
    }

    public function _rules()
    {
        $this->validation->setRules([
            'produk_id' => ['label' => 'Produk', 'rules' => 'required'],
            'jenis_id' => ['label' => 'Jenis Kayu', 'rules' => 'required'],
            'negara_id' => ['label' => 'Negara Panen', 'rules' => 'required'],
            'jumlah' => ['label' => 'Jumlah', 'rules' => 'required|numeric'],
            'volume' => ['label' => 'Volume', 'rules' => 'required|numeric'],
            'berat' => ['label' => 'Berat', 'rules' => 'required|numeric'],
            'nilai' => ['label' => 'Nilai', 'rules' => 'required|numeric'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);

        $url = '/detailpengajuan/detail/'.$input['pengajuan_id'];
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validation);
        }

        $data = [
            'pengajuan_id' => $input['pengajuan_id'],
            'produk_id' => $input['produk_id'],
            'jenis_id' => implode(';', $input['jenis_id']),
            'negara_id' => implode(';', $input['negara_id']),
            'jumlah' => $input['jumlah'],
            'volume' => $input['volume'],
            'berat' => $input['berat'],
            'nilai' => $input['nilai'],
        ];

        if ($input['id']) {
            $data['id'] = $input['id'];
        }

        // Update Tanggal Pengajuan
        $updatedAt = ['updated_at' => Time::now('Asia/Jakarta', 'en_US'), 'pengajuan_id' => $input['pengajuan_id']];
        $this->pengajuan->save($updatedAt);

        $this->detail->save($data);
        setToast('success', 'Data berhasil disimpan');

        return redirect()->to($url);
    }

    public function delete($id, $detail)
    {
        $this->detail->delete($id);

        setToast('success', "Data berhasil dihapus");
        return redirect()->to('/detailpengajuan/detail/'.$detail);
    }
}
