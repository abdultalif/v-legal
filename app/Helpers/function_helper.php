<?php
function setPesan($tipe = 'success', $pesan = '')
{
    $icon['success'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>';
    $icon['info'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12.01" y2="8"></line><polyline points="11 12 12 12 12 16 13 16"></polyline></svg>';
    $icon['waring'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v2m0 4v.01"></path><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path></svg>';
    $icon['danger'] = '<svg xmlns="http://www.w3.org/2000/svg" class="icon mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="9"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';

    $alert = "";
    $alert .= "<div class='alert alert-{$tipe} alert-dismissible' role='alert'>";
    $alert .= "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>";
    $alert .= $icon[$tipe] . $pesan;
    $alert .= "</div>";

    return session()->setFlashdata('pesan', $alert);
}

function setToast($tipe = 'success', $pesan = '')
{
    $toast  = "Toast.fire({";
    $toast .= "icon: '{$tipe}',";
    $toast .= "title: '{$pesan}'";
    $toast .= "});";

    return session()->setFlashdata('toast', $toast);
}

function setAlert($icon = 'success', $title='', $text = '')
{
    $alert =  "Swal.fire({";
    $alert .= "icon: '{$icon}',";
    $alert .= "title: '{$title}',";
    $alert .= "html: '{$text}',";
    $alert .= "showCloseButton: true";
    $alert .= "});";

    return session()->setFlashdata('alert', $alert);
}

function active($menu = "", $sub = "")
{
    $uri = service('uri')->getSegment(1);
    $uri2 = service('uri')->getSegment(2);

    if ($uri == "") {
        $uri = "home";
    }

    if ($uri2 == "") {
        $uri2 = "index";
    }

    if ($uri == $menu) {
        if ($sub != "") {
            if ($uri2 == $sub) {
                return "active";
            }
        } else {
            return "active";
        }
    }
}

function open_menu($menu = [])
{
    $uri = service('uri')->getSegment(1);

    return in_array($uri, $menu) ? "menu-open menu-is-opening" : "";
}

function is_logged_in()
{
    return session()->has('svlksarbi_user');
}

function getFormatedNPWP($npwp)
{
    $ret = substr($npwp, 0, 2).'.';
    $ret .= substr($npwp, 2, 3).'.';
    $ret .= substr($npwp, 5, 3).'.';
    $ret .= substr($npwp, 8, 1).'-';
    $ret .= substr($npwp, 9, 3).'.';
    $ret .= substr($npwp, 12, 3);
    return $ret;
}

function userdata($data = null)
{
    $user = new \App\Models\UserModel();

    $id = session()->get('svlksarbi_user');
    $getUser = $user->get($id);

    if (!$data) {
        return $getUser;
    } else {
        return $getUser[$data];
    }
}

function clientdata($user_id)
{
    $client = new \App\Models\ClientModel();
    $result = $client->where(['user_id'=>$user_id])->first();

    return $result;
}

function is_superadmin()
{
    return userdata('role') == "superadmin" ? 1 : 0;
}

function is_admin()
{
    return userdata('role') == "admin" ? 1 : 0;
}

function selected($data="", $val = "")
{
    if ($data == $val) {
        return "selected";
    }
}

function format_tanggal($tanggal, $format)
{
    return date($format, strtotime($tanggal));
}

function format_angka($angka)
{
    return rtrim(rtrim(number_format($angka, 2, ",", "."), '0'), '.');
}

function smarty_filesize($size)
{
    $size = max(0, (int)$size);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;

    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function cekLMK()
{
    if (userdata('role') != 'admin') {
        $lmk         = new \App\Models\LmkModel();
        $client      = @clientdata(userdata('user_id'))['client_id'];
        $bln         = date('Y-m', strtotime("-31 days"));
        $bulan       = date('n', strtotime("-31 days"));
        $tahun       = date('Y', strtotime("-31 days"));

        return $lmk->cekLMKBulanan($client, $bulan, $tahun);
    }
}

function countDraft()
{
    $pengajuan  = new \App\Models\PengajuanModel();
    $draft = $pengajuan->where(['status_dokumen'=>'dikirim'])->findAll();

    return count($draft);
}

function countPembatalan()
{
    $pembatalan  = new \App\Models\PembatalanModel();
    $send = $pembatalan->where(['status'=>'draft'])->findAll();

    return count($send);
}

function countDraftClient()
{
    $pengajuan  = new \App\Models\PengajuanModel();
    $client = @clientdata(userdata('user_id'))['client_id'];
    $draft = $pengajuan->where(['status_dokumen'=>'draft','client_id'=>$client])->findAll();

    return count($draft);
}

function checkExternalFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $retCode;
}

function sendSMTP($mailTo = "", $subject = "", $msg = "", $success = "", $pdf = null, $filename = "")
{
    $lsName     = env('ls.name');
    $lsWebsite  = env('ls.website');
    $lsVlegal   = env('app.baseURL');
    $msg .= "<br/><br/>--<br/><b>.:: V-LEGAL ::.</b><br/>{$lsName}<br/>Website : {$lsWebsite}<br/>V-Legal : {$lsVlegal}";

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = env('mail.host');
        $mail->SMTPAuth   = true;
        $mail->Username   = env('mail.senderEmail');
        $mail->Password   = env('mail.senderPass');
        $mail->SMTPSecure = env('mail.secure');
        $mail->Port       = env('mail.port');
        $mail->setFrom(env('mail.senderEmail'), env('mail.senderName'));
        $mail->addAddress($mailTo);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $msg;
        if ($pdf != null) {
            $mail->addStringAttachment($pdf, $filename);
        }
        $mail->send();
        setToast('success', $success);
    } catch (PHPMailer\PHPMailer\Exception $e) {
        setAlert('error', "Send Email failed. Error: ".$mail->ErrorInfo);
    }
}

function skipPages($pageCount = 0)
{
    $skipPages = [];
    if ($pageCount == 7) {
        $skipPages = [4,6];
    } elseif ($pageCount == 14) {
        $skipPages = [4,6,11,13];
    } elseif ($pageCount == 21) {
        $skipPages = [4,6,14,15,18,19];
    } elseif ($pageCount == 28) {
        $skipPages = [4,6,17,18,19,23,24,25];
    } elseif ($pageCount == 35) {
        $skipPages = [4,6,20,21,22,23,28,29,30,31];
    } else {
        $skipPages = [];
    }

    return $skipPages;
}
