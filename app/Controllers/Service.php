<?php
namespace App\Controllers;

use Irsyadulibad\DataTables\DataTables;
use setasign\Fpdi\Fpdi;

class Service extends BaseController
{
    public function __construct()
    {
        require APPPATH . 'ThirdParty/nusoap.php';

        $this->server   = env('silk.server');
        $this->username = env('silk.username');
        $this->password = env('silk.password');
        $this->no_lvlk  = env('silk.no_lvlk');

        $this->soap_client = new \nusoap_client($this->server, 'wsdl', true);
    }

    public function index()
    {
        $data = [
            'title' => 'Cek Status',
            'status' => session()->getFlashdata('status_dokumen'),
            'validation' => $this->validation
        ];

        return view('service/status', $data);
    }

    private function request($aksi, $string2)
    {
        $request = [
            'string0' => $this->username,
            'string1' => $this->password,
            'string2' => $string2
        ];

        $result = $this->soap_client->call($aksi, $request);
        $result_xml = simplexml_load_string($result);
        $result_json = json_encode($result_xml);

        return json_decode($result_json, true);
    }

    public function cekStatus()
    {
        $this->validation->setRules([
            'no_dokumen' => ['label' => 'Nomor Dokumen', 'rules' => 'required'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/vlegal')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $no_dokumen = $this->request->getVar('no_dokumen', FILTER_SANITIZE_STRING);

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<vlegal_license>';
        $xml .= "<no_dokumen>{$no_dokumen}</no_dokumen>";
        $xml .= '</vlegal_license>';

        $request = $this->request('cekStatus', $xml);
        if ($request['total'] > 0) {
            $request['no_dokumen'] = $no_dokumen;
            if (checkExternalFile($request['link_cetak']) == "200") {
                $saveTo = FCPATH.'uploads/vlegal/'.$no_dokumen.'.pdf';
                copy($request['link_cetak'], $saveTo);
            }
            session()->setFlashdata('status_dokumen', $request);
        } else {
            setToast('error', "Dokumen tidak ditemukan.");
        }

        return redirect()->to('/vlegal');
    }

    private function _batalPengajuan($doc, $inv)
    {
        // cari dokumen dengan invoice yg sudah terbit
        $terkirim = $this->terkirim->where(['no_dokumen'=>$doc,'no_invoice'=>$inv,'status'=>'terbit'])->first();
        $pengajuan = $this->pengajuan->where(['no_invoice'=>$inv,'status_dokumen'=>'diterima'])->first();

        if ($terkirim) {
            $updateTerkirim = [
                'sent_id' => $terkirim['sent_id'],
                'status' => 'batal'
            ];

            $this->terkirim->save($updateTerkirim);
        }

        if ($pengajuan) {
            $update = [
                'pengajuan_id'      => $pengajuan['pengajuan_id'],
                'status_dokumen'    => 'dibatalkan',
                'keterangan_status' => 'Pembatalan dokumen: '.date('d/m/Y'),
            ];

            $this->pengajuan->save($update);
        }
    }

    public function send_pembatalan($id)
    {
        $pembatalan = $this->pembatalan->where(['pembatalan_id'=>$id])->first();
        $ket = htmlspecialchars($pembatalan['keterangan']);

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<vlegal_license>';
        $xml .= "<no_dokumen>{$pembatalan['no_dokumen']}</no_dokumen>";
        $xml .= "<keterangan>{$ket}</keterangan>";
        $xml .= '</vlegal_license>';

        $this->_batalPengajuan($pembatalan['no_dokumen'], $pembatalan['no_invoice']);

        $request = $this->request('cancelDocument', $xml);
        $status = "";

        if ($request['return_send'] == "R00") {
            $this->_batalPengajuan($pembatalan['no_dokumen'], $pembatalan['no_invoice']);

            $status = "sukses";
            setToast('success', 'Dokumen berhasil dibatalkan');
        } else {
            $status = "gagal";
            $error = $request['return_send'].': '.$request['keterangan'];
            setAlert('error', 'Gagal', $error);
        }

        $updateData = [
            'pembatalan_id' => $id,
            'status' => $status
        ];

        $this->pembatalan->save($updateData);
        return redirect()->to('/pembatalan');
    }

    public function sendDocument()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/review');
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);

        // Data Vlegal
        $today = date('Ymd');
        $pengajuan = $this->pengajuan->sendDetail($input['pengajuan_id']);
        $client = $this->client->get($pengajuan['client_id']);
        $no_sertifikat = explode('-', $client['no_sertifikat'])[0];
        $buyer = $this->buyer->join('negara', 'negara_id', 'left')->where(['buyer_id'=>$pengajuan['buyer_id']])->first();
        $detail = $this->detail->get($input['pengajuan_id']);

        // encode
        $namaBuyer = htmlspecialchars($buyer['nama_buyer']);
        $alamatClient = htmlspecialchars($client['alamat_client']);
        $alamatBuyer = htmlspecialchars($buyer['alamat_buyer']);
        $lokasiStuffing = htmlspecialchars($pengajuan['lokasi_stuffing']);
        $tgl_invoice = date('Ymd', strtotime($pengajuan['tgl_invoice']));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= "<vlegal_license>";
        $xml .= "<header>";
        $xml .= "<negara_tujuan>{$pengajuan['kode_negara']}</negara_tujuan>";
        $xml .= "<skema_kerjasama>1</skema_kerjasama>";
        $xml .= "<nama_importir>{$namaBuyer}</nama_importir>";
        $xml .= "<alamat_importir>{$alamatBuyer}</alamat_importir>";
        $xml .= "<negara_importir>{$buyer['kode_negara']}</negara_importir>";
        $xml .= "<loading_port>{$pengajuan['kode_loading']}</loading_port>";
        $xml .= "<discharge_port>{$pengajuan['kode_discharge']}</discharge_port>";
        $xml .= "<no_slk>{$no_sertifikat}</no_slk>";
        $xml .= "<no_dokumen>{$input['no_dokumen']}</no_dokumen>";
        $xml .= "<tgl_dokumen>{$today}</tgl_dokumen>";
        $xml .= "<no_invoice>{$pengajuan['no_invoice']}</no_invoice>";
        $xml .= "<tgl_invoice>{$tgl_invoice}</tgl_invoice>";
        $xml .= "<transportasi>{$pengajuan['alat_angkut']}</transportasi>";
        $xml .= "<npwp_eksportir>{$client['npwp']}</npwp_eksportir>";
        $xml .= "<nama_eksportir>{$client['nama_client']}</nama_eksportir>";
        $xml .= "<alamat_eksportir>{$alamatClient}</alamat_eksportir>";
        $xml .= "<kode_propinsi>{$client['kode_provinsi']}</kode_propinsi>";
        $xml .= "<kode_kabupaten>{$client['kode_kabupaten']}</kode_kabupaten>";
        $xml .= "<no_etpik>{$client['no_etpik']}</no_etpik>";
        $xml .= "<keterangan>{$pengajuan['keterangan']}</keterangan>";
        $xml .= "<nama_ttd>{$input['kode_pejabat']}</nama_ttd>";
        $xml .= "<tempat_ttd>BOGOR</tempat_ttd>";
        $xml .= "<digital_sign>1</digital_sign>";
        $xml .= "<location_stuffing>{$lokasiStuffing}</location_stuffing>";
        $xml .= "</header>";
        $xml .= "<detil>";
        foreach ($detail as $item) {
            $nmProduk = htmlspecialchars($item['nama_produk']);
            $xml .= "<data_barang>";
            $xml .= "<kode_hs>{$item['kode_hs']}</kode_hs>";
            $xml .= "<hs_printed>{$item['kode_hs']}</hs_printed>";
            $xml .= "<deskripsi_barang>{$nmProduk}</deskripsi_barang>";
            $xml .= "<volume>{$item['volume']}</volume>";
            $xml .= "<netto>{$item['berat']}</netto>";
            $xml .= "<jumlah_unit>{$item['jumlah']}</jumlah_unit>";
            $xml .= "<value>{$item['nilai']}</value>";
            $xml .= "<valuta>{$item['mata_uang']}</valuta>";

            $jenis = explode(';', $item['jenis_id']);
            $nama_ilmiah = '';
            foreach ($jenis as $jns) {
                if ($nama_ilmiah != '') {
                    $nama_ilmiah .= ';';
                }
                $nama_ilmiah .= $this->kayu->get($jns)['nama_jenis'];
            }
            $xml .= "<nama_ilmiah>{$nama_ilmiah}</nama_ilmiah>";

            $negara = explode(';', $item['negara_id']);
            $negara_panen = '';
            foreach ($negara as $ngr) {
                if ($negara_panen != '') {
                    $negara_panen .= ';';
                }
                $negara_panen .= $this->negara->get($ngr)['kode_negara'];
            }
            $xml .= "<negara_panen>{$negara_panen}</negara_panen>";
            $xml .= "</data_barang>";
        }
        $xml .= "</detil>";
        $xml .= "</vlegal_license>";

        // helper('xml');
        // header("Content-Type:text/xml");
        // print_r(xml_convert($xml));

        $request = $this->request('sendDocument', $xml);
        if ($request['return_send'] == "R00") {
            $updatePengajuan = [
                'pengajuan_id'      => $pengajuan['pengajuan_id'],
                'status_dokumen'    => 'diterima',
                'keterangan_status' => 'Dokumen telah diterbitkan',
                'reviewer'          => userdata('user_id')
            ];

            $this->pengajuan->save($updatePengajuan);

            $no_dokumen = date('y').'.'.sprintf("%05s", $input['no_dokumen']).'-'.sprintf("%05s", $no_sertifikat).'.'.$this->no_lvlk.'-'.'ID'.'-'.$pengajuan['kode_negara'];
            $local = '/uploads/vlegal/'.$no_dokumen.'.pdf';
            $fileVlegal = FCPATH.$local;
            $insert = [
                'no_dokumen' => $no_dokumen,
                'no_invoice' => $pengajuan['no_invoice'],
                'link_cetak' => $local,
                'barcode'    => $request['barcode']
            ];

            $this->terkirim->save($insert);

            // Copy file dari url ke server lokal
            if (checkExternalFile($request['link_cetak']) == "200") {
                $saveTo = $fileVlegal;
                copy($request['link_cetak'], $saveTo);
                setToast('success', 'Dokumen berhasil diterbitkan');

                return redirect()->to('/terkirim');
            } else {
                setToast('info', 'Gagal copy dokumen ke server lokal');
            }
        } else {
            $updatePengajuan = [
                'pengajuan_id'      => $pengajuan['pengajuan_id'],
                'status_dokumen'    => 'dikirim',
                'keterangan_status' => $request['link_cetak'],
                'reviewer'          => userdata('user_id')
            ];

            $this->pengajuan->save($updatePengajuan);

            $error = $request['return_send'].': '.$request['link_cetak'];
            setAlert('error', 'Kesalahan', $error);
            return redirect()->back();
        }

        return redirect()->to('/terkirim');
    }

    public function json_terkirim()
    {
        $query = DataTables::use('pengajuan_sent')
                ->select('sent_id,no_dokumen,no_invoice,barcode,link_cetak,status,tgl_sent')
                ->make(true);

        return $this->response->setJSON($query);
    }

    public function terkirim()
    {
        $data = [
            'title' => 'Dokumen Terkirim'
        ];

        return view('service/list_terkirim', $data);
    }

    public function add_terkirim()
    {
        $data = [
            'title' => 'Input Dokumen Manual',
            'no_invoice' => $this->pengajuan->getWhere(['status_dokumen' => 'dikirim'])->getResultArray(),
            'validation' => $this->validation
        ];

        return view('service/add_terkirim', $data);
    }

    public function save_terkirim()
    {
        $this->validation->setRules([
            'no_dokumen' => ['label' => 'Nomor Dokumen', 'rules' => 'required'],
            'no_invoice' => ['label' => 'Nomor Invoice', 'rules' => 'required'],
            'barcode' => ['label' => 'barcode', 'rules' => 'required'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validation);
        }

        $no_dokumen = $this->request->getVar('no_dokumen');
        $no_invoice = $this->request->getVar('no_invoice');

        $input = [
            'no_dokumen'    => $no_dokumen,
            'no_invoice'     => $no_invoice,
            'barcode'       => $this->request->getVar('barcode'),
            'link_cetak'    => '/uploads/vlegal/'.$no_dokumen.'pdf',
        ];

        $this->terkirim->save($input);

        $getPengajuan = $this->pengajuan->getWhere(['no_invoice'=>$no_invoice])->getRow();
        $updatePengajuan = [
            'pengajuan_id'      => $getPengajuan->pengajuan_id,
            'status_dokumen'    => 'diterima', 
        ];

        $this->pengajuan->save($updatePengajuan);

        setToast('success', "Data berhasil disimpan");
        return redirect()->to('/terkirim');
    }

    public function delete_terkirim($id)
    {
        if ($this->request->getMethod() !== 'delete') {
            return redirect()->to('/terkirim');
        }

        $this->terkirim->delete($id);

        setToast('success', 'Data berhasil dihapus');
        return redirect()->to('/terkirim');
    }

    public function download_vlegal($no)
    {
        $vlegal = FCPATH.'uploads/vlegal/'.$no.'.pdf';

        if (is_file($vlegal)) {
            return $this->response->download($vlegal, null);
        } else {
            setToast('error', 'File not found!');

            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }

    public function for_auditee($no)
    {
        $vlegal = FCPATH.'uploads/vlegal/'.$no.'.pdf';

        if (is_file($vlegal)) {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($vlegal);
            $skipPages = skipPages($pageCount);

            for ($pageNo=1; $pageNo<=$pageCount; $pageNo++) {
                if (in_array($pageNo, $skipPages)) {
                    continue;
                }

                $templateID = $pdf->importPage($pageNo);
                $pdf->getTemplateSize($templateID);
                $pdf->addPage();
                $pdf->useTemplate($templateID);
            }

            $pdf->Output('I', $no.'.pdf');
            exit();
        } else {
            setToast('error', 'File not found!');

            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }

    public function send_to_email($no)
    {
        $vlegal = FCPATH.'uploads/vlegal/'.$no.'.pdf';

        if (is_file($vlegal)) {
            $terkirim = $this->terkirim->join('pengajuan', 'no_invoice', 'left')->where('no_dokumen', $no)->get()->getRow();
            $client = $this->client->get($terkirim->client_id);

            $data = [
                'title' => "Kirim ke Email",
                'no_vlegal' => $no,
                'no_invoice' => $terkirim->no_invoice,
                'email' => $client['email'],
                'file' => $vlegal,
                'validation' => $this->validation
            ];

            return view('service/sendToEmail', $data);
        } else {
            setToast('error', 'File not found!');

            return redirect()->to('/terkirim');
        }
    }

    public function proseskirim()
    {
        $this->validation->setRules([
            'no_vlegal' => ['label' => 'Nomor V-Legal', 'rules' => 'required'],
            'subject' => ['label'=> 'Subject', 'rules'=>'required'],
            'email' => ['label' => 'Email', 'rules' => 'required'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $vlegal = FCPATH.'uploads/vlegal/'.$input['no_vlegal'].'.pdf';

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($vlegal);
        $skipPages = skipPages($pageCount);

        for ($pageNo=1; $pageNo<=$pageCount; $pageNo++) {
            if (in_array($pageNo, $skipPages)) {
                continue;
            }

            $templateID = $pdf->importPage($pageNo);
            $pdf->getTemplateSize($templateID);
            $pdf->addPage();
            $pdf->useTemplate($templateID);
        }

        $attch = $pdf->Output('S');
        $filename = $input['no_vlegal'].".pdf";
        $lsName = env('ls.name');
        $lsWebsite = env('ls.website');
        $email = $input['email'];
        $subject = $input['subject'];
        $msg = env('mail.body');

        sendSMTP($email, $subject, $msg, "Berhasil dikirim", $attch, $filename);
        return redirect()->to('/terkirim');
    }
}
