<?php
namespace App\Controllers;

class Auth extends BaseController
{
    public function __construct()
    {
        // Auto Captcha
        // $this->captcha = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), 0, 5);
        // Custom Captcha
        $this->pohon = ['Mahoni','Jati','Eukaliptus','Meranti','Merbau','Sonokeling','Eboni','Sengon','Karet','Mangrove','Agathis','Akasia','Kumea','Balsa','Bangkirai','Ulin','Keruing','Albasia','Malapoga','Mindi'];
        $this->captcha = $this->pohon[array_rand($this->pohon)];
    }

    public function index()
    {
        if (session()->has('svlksarbi_user')) {
            return redirect()->to('/home');
        }

        $data = [
            'title'         => 'Login',
            'captcha'       => $this->captcha,
            'validation'    => $this->validation
        ];

        return view('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'title'         => 'Login',
            'validation'    => $this->validation
        ];

        return view('auth/register', $data);
    }

    public function proses()
    {
        $this->validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required'],
            'captcha'  => ['label' => 'Captcha', 'rules' => 'required|matches[captcha_code]'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/auth')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $username = $input['username'];
        $password = $input['password'];

        $user = $this->user->getUserByUsername($username);
        if (!$user) {
            setToast('error', "Username/Password Salah");
        } else {
            if (password_verify($password, $user['password'])) {
                if ($user['status']) {
                    setToast('success', "Login berhasil");
                    session()->setFlashdata('preloader', 'ok');
                    session()->set('svlksarbi_user', $user['user_id']);
                    return redirect()->to('/home');
                } else {
                    setPesan('danger', "Akun anda tidak aktif! Silahkan cek email atau hubungi admin.");
                }
            } else {
                setToast('error', "Username/Password Salah");
            }
        }

        return redirect()->to('/auth')->withInput();
    }

    private function _rules()
    {
        $this->validation->setRules([
            'name' => ['label' => 'Nama', 'rules' => 'required'],
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email|is_unique[users.email]'],
            'username' => ['label' => 'Username', 'rules' => 'required|alpha_dash|min_length[4]|is_unique[users.username]'],
            'password' => ['label' => 'Password', 'rules' => 'required|alpha_dash|min_length[4]'],
        ]);
    }

    public function save()
    {
        $this->_rules();

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/auth/register')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $input = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $input['password']  = password_hash($input['password'], PASSWORD_DEFAULT);

        $this->user->save($input);

        // generate aktivasi token
        helper('text');
        $generate = [
            'user_id' => $this->user->getInsertID(),
            'token' => random_string('alnum', 64),
            'tipe' => 'activation',
            'expired' => date('Y-m-d', strtotime("+3 day", strtotime(date('Y-m-d')))),
        ];

        $this->token->save($generate);

        // send token
        $this->sendActivation($generate['token'], $input['email'], $generate['expired']);

        setToast('success', "Daftar berhasil! Silahkan cek email anda untuk mengaktifkan akun.");
        return redirect()->to('/auth');
    }

    private function sendActivation($token, $email, $expired)
    {
        $link = base_url().'/auth/activate/'.$token;
        $expr = format_tanggal($expired, 'd M Y');

        $subject = "Aktivasi Akun V-Legal ".$this->lsAlias;
        $msg = "
        Silahkan buka link berikut ini untuk mengaktifkan akun Aplikasi V-LEGAL {$this->lsAlias}.<br/>
        <a href='{$link}' target='_blank'>{$link}</a><br/><br/>
        Expired : {$expr}
        ";

        sendSMTP($email, $subject, $msg, "Berhasil. Silahkan periksa email anda untuk verifikasi");
        return redirect()->to('/auth');
    }

    public function activate($token)
    {
        $token = $this->token->where(['token'=>$token, 'tipe'=>'activation'])->orderBy('token_id', 'desc')->first();
        if (!$token) {
            setPesan('danger', 'Token tidak valid!');
        } else {
            if (date('Y-m-d') > $token['expired']) {
                setPesan('danger', 'Token sudah kadaluwarsa!');
            } else {
                $user = [
                    'user_id'   => $token['user_id'],
                    'status'    => 1
                ];

                $this->user->save($user);
                setPesan('success', 'Akun anda berhasil diaktifkan! Silahkan login.');
            }
        }
        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy('svlksarbi_user');
        return redirect()->to('/auth');
    }

    public function forgot()
    {
        $data = [
            'title' => "Forgot Password",
            'captcha'       => $this->captcha,
            'validation'    => $this->validation
        ];

        return view('auth/forgot-password', $data);
    }

    public function send()
    {
        $this->validation->setRules([
            'email' => ['label' => 'Email', 'rules' => 'required|valid_email'],
            'captcha'  => ['label' => 'Captcha', 'rules' => 'required|matches[captcha_code]'],
        ]);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/auth/forgot')
                ->withInput()
                ->with('validation', $this->validation);
        }

        $email = $this->request->getVar('email', FILTER_SANITIZE_STRING);
        $cekEmail = $this->user->cekEmail($email);

        if ($cekEmail) {
            helper('text');
            $token = random_string('alnum', 64);
            $besok = strtotime("+1 day", strtotime(date('Y-m-d')));

            $data_token = [
                'user_id'   => $cekEmail['user_id'],
                'token'     => $token,
                'expired'   => date('Y-m-d', $besok),
                'tipe'      => 'forgot_password',
                'email'     => $email
            ];

            $this->token->save($data_token);
            return $this->sendToken($data_token);
        } else {
            setToast('error', 'Email tidak terdaftar');
            return redirect()->to('/auth/forgot');
        }
    }

    private function sendToken($data)
    {
        $subject = "Reset Password V-Legal ".$this->lsAlias;
        $link    = base_url().'/auth/ganti/'.$data['token'];
        $exprTgl = format_tanggal($data['expired'], 'd M Y');
        $msg     = "
        Silahkan buka link berikut ini untuk dialihkan ke halaman reset password Aplikasi V-Legal {$this->lsAlias}.<br/>
        <a href='{$link}'>{$link}</a>
        <br/><br/>
        Expired Date : {$exprTgl}
        ";

        sendSMTP($data['email'], $subject, $msg, "Berhasil. Silahkan periksa email anda");
        return redirect()->to('/auth');
    }

    public function ganti($token)
    {
        $token = $this->token->where(['token'=>$token,'tipe'=>'forgot_password'])->orderBy('token_id', 'desc')->first();
        if (!$token) {
            setPesan('danger', 'Token tidak valid!');
            return redirect()->to('/auth/forgot');
        } else {
            if (date('Y-m-d') > $token['expired']) {
                setPesan('danger', 'Token sudah kadaluwarsa!');
                return redirect()->to('/auth/forgot');
            } else {
                $data = [
                    'title' => "Ganti Password",
                    'token' => $token['token'],
                    'user'  => $this->user->where(['user_id'=>$token['user_id']])->first(),
                    'validation' => $this->validation
                ];

                return view('auth/ganti-password', $data);
            }
        }
    }

    public function simpan()
    {
        $this->validation->setRules([
            'password' => ['label' => 'Password', 'rules' => 'required|alpha_dash|min_length[4]'],
            'password2'  => ['label' => 'Konfirmasi Password', 'rules' => 'required|matches[password]'],
        ]);

        $token = $this->request->getVar('token', FILTER_SANITIZE_STRING);

        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()
                ->to('/auth/ganti/'.$token)
                ->withInput()
                ->with('validation', $this->validation);
        }

        $user_id = $this->request->getVar('user_id', FILTER_SANITIZE_STRING);
        $password = $this->request->getVar('password', FILTER_SANITIZE_STRING);

        $input = [
            'user_id'   => $user_id,
            'password'  => password_hash($password, PASSWORD_DEFAULT)
        ];

        // Delete Token
        $token_id = $this->token->where(['token'=>$token])->first()['token_id'];
        $this->token->delete($token_id);
        $this->user->save($input);

        setToast('success', 'Password berhasil diubah');
        return redirect()->to('/auth');
    }
}
