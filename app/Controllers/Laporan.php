<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function index($input = null, $laporan = null)
    {
        $data = [
            'title'         => 'Laporan Penerbitan V-Legal',
            'validation'    => $this->validation,
            'client'        => $this->client->get(),
            'reveiwer'      => $this->user->where(['role'=>'admin'])->findAll(),
            'input'         => $input,
            'laporan'       => $laporan
        ];

        return view('laporan/index', $data);
    }

    public function get()
    {
        $this->validation->setRules([
            'tgl_awal' => ['label' => 'Periode Awal', 'rules' => 'required'],
            'tgl_akhir' => ['label' => 'Periode Akhir', 'rules' => 'required'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/laporan')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $laporan = $this->pengajuan->getLaporan($input);

        return $this->index($input, $laporan);
    }

    public function cetakPDF()
    {
        $dompdf = new \Dompdf\Dompdf();

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $data['laporan'] = $this->pengajuan->getLaporan($input);
        $data['input']  = $input;

        $dompdf->loadHtml(view('laporan/cetak_pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Cetak Laporan.pdf", array("Attachment" => false));

        exit(0);
    }
}
