<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['function', 'form', 'url'];

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        session();
        date_default_timezone_set('Asia/Jakarta');

        $this->validation =  \Config\Services::validation();
        $this->response =  \Config\Services::response();

        // Models
        $this->client = new \App\Models\ClientModel();
        $this->user = new \App\Models\UserModel();
        $this->token = new \App\Models\TokenModel();
        // Master
        $this->supplier = new \App\Models\SupplierModel();
        $this->buyer = new \App\Models\BuyerModel();
        $this->negara = new \App\Models\NegaraModel();
        $this->provinsi = new \App\Models\ProvinsiModel();
        $this->kabupaten = new \App\Models\KabupatenModel();
        $this->loading = new \App\Models\PortloadingModel();
        $this->discharge = new \App\Models\PortdischargeModel();
        $this->kayu = new \App\Models\JenisModel();
        $this->produk = new \App\Models\ProdukModel();
        $this->pejabat = new \App\Models\PejabatModel();
        $this->uang = new \App\Models\MatauangModel();
        // Transaction
        $this->pengajuan = new \App\Models\PengajuanModel();
        $this->detail = new \App\Models\DetailpengajuanModel();
        $this->lampiran = new \App\Models\LampiranModel();
        $this->lmk = new \App\Models\LmkModel();
        // Services
        $this->terkirim = new \App\Models\TerkirimModel();
        $this->pembatalan = new \App\Models\PembatalanModel();
        // Validation
        $this->mimeType = [
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg','image/png', 'application/pdf', 'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();
    }
}
