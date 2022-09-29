<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PengajuanFilter implements FilterInterface
{
    public function alert()
    {
        $alert = "";
        $alert .= "<div class='alert alert-danger alert-dismissible' role='alert'>";
        $alert .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
        $alert .= '<svg xmlns="http://www.w3.org/2000/svg" class="icon mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
        $alert .= "Silahkan lengkapi data klien terlebih dahulu!";
        $alert .= "</div>";

        return $alert;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $id = session()->get('svlksarbi_user');
        $user = new \App\Models\UserModel();
        $role = $user->get($id)['role'];

        if (!in_array($role, ["admin", "superadmin"])) {
            $client = new \App\Models\ClientModel();
            if (!$client->getByUserId($id)) {
                session()->setFlashdata('pesan', $this->alert());
                return redirect()->to('/client/add');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
