<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class SiteConfig extends BaseConfig
{
    /* Konfigurasi untuk mengirim email */
    public function mail($key="senderName")
    {
        $data = [
            'senderName' => "no-reply.vlegalsic",
            'senderEmail' => "noreply.sic.vlegal@gmail.com",
            'senderPass' => "sicasik2021",
            'replyEmail' => "sic.sertifikasi@yahoo.co.id",
            'replyName' => "Sarbi International Certification"
        ];

        return $data[$key];
    }

    // Konfigurasi untuk webservice kementrian
    public function silk($key = "server")
    {
        $data = [
            'server' => 'http://silk.menlhk.go.id/ws/server2.php?wsdl',
            'username' => 'sarbiic',
            'password' => 'p4sw0rd',
            'no_lvlk' => '007'
        ];

        return $data[$key];
    }
}
