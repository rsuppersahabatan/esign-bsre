<?php
namespace registrasiUser;

use getAccessToken\getAccessToken;

// error_reporting(~E_NOTICE);

// ============= Contoh parsing variabel dari tipe data multipart ====================
// $ktp_name = $_FILES["ktp"]["name"];
// $ktp_type = $_FILES["ktp"]["type"];
// $ktp_size = $_FILES["ktp"]["size"];
// $ktp_tmp = $_FILES["ktp"]["tmp_name"];

// $srt_rekom_name = $_FILES["srt_rekom"]["name"];
// $srt_rekom_type = $_FILES["srt_rekom"]["type"];
// $srt_rekom_size = $_FILES["srt_rekom"]["size"];
// $srt_rekom_tmp = $_FILES["srt_rekom"]["tmp_name"];

// $sk_name = $_FILES["sk"]["name"];
// $sk_type = $_FILES["sk"]["type"];
// $sk_size = $_FILES["sk"]["size"];
// $sk_tmp = $_FILES["sk"]["tmp_name"];

// $img_ttd_name = $_FILES["img_ttd"]["name"];
// $img_ttd_type = $_FILES["img_ttd"]["type"];
// $img_ttd_size = $_FILES["img_ttd"]["size"];
// $img_ttd_tmp = $_FILES["img_ttd"]["tmp_name"];

// $filektp = new CURLFile($ktp_tmp, $ktp_type, $ktp_name);
// $filesrtrekom = new CURLFile($srt_rekom_tmp, $srt_rekom_type, $srt_rekom_name);
// $filesk = new CURLFile($sk_tmp, $sk_type, $sk_name);
// $fileimgttd = new CURLFile($img_ttd_tmp, $img_ttd_type, $img_ttd_name);

class registrasiUser
{
    public function __construct()
    {

    }

    public $filektp;
    public $filesrtrekom;
    public $filesk;
    public $fileimgttd;
    public $message = array();
    public $prop = "";
    public $status = true;

    public function index()
    {
        $response = "";
        // if (!$this->status) {

            // require_once "req.php";
            require_once realpath(__DIR__ . '/..') . "/req.php";
            $url = $endPoint->getFullName("registrasi_user");
            $url = str_replace(" ", "%20", $url);

            $data = array(
                'ktp' => $this->filektp,
                'surat_rekomendasi' => $this->filesrtrekom,
                'sk_pengangkatan' => $this->filesk,
                'image_ttd' => $this->fileimgttd,
            );
            // echo json_encode($_SESSION['reg_user']) . "<br>";
            // echo $_SESSION['reg_user']['kota'];die();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_PROXY => $proxy[0],
                CURLOPT_PROXYPORT => $proxy[1],
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer $access_token",
                    "cache-control: no-cache",
                    "postman-token: 846b2319-3de9-cbe7-b282-f3705891a127",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $resp = json_decode($response);
                if (isset($resp->error)) {
                    if ($resp->error == "invalid_token") {
                        require_once "getAccessToken.php";
                        $getToken = new getAccessToken();
                        $getToken->index();
                        echo $reload;
                    } 
                } 
            }
        // }
        return $response;
    }

    public function tes()
    {
        $this->message['prop'] = "ini adalah tes dari array";
    }

    public function getKtp($ktp_name, $ktp_type, $ktp_size, $ktp_tmp)
    {
        $this->status = true;
        switch (empty($ktp_name)) {
            case true:
                $this->message['getKtp'] = "<font color=red><b>Upload dulu scan/foto KTP anda</b></font>";
                break;
            default:
                $this->message['getKtp'] = null;
                $this->status = false;
                break;
        }

        if (!$this->status) {
            $filektp = new \CURLFile($ktp_tmp, $ktp_type, $ktp_name);
            return $this->filektp = $filektp;
        }

    }

    public function getsrtRekom($srt_rekom_name, $srt_rekom_type, $srt_rekom_size, $srt_rekom_tmp)
    {
        $this->status = true;
        switch (empty($srt_rekom_name)) {
            case true:
                $this->message['getsrtRekom'] = "<font color=red><b>Upload dulu scan/foto surat Rekomendasi anda</b></font>";
                break;
            default:
                $this->message['getsrtRekom'] = null;
                $this->status = false;
                break;
        }

        if (!$this->status) {
            $filesrtrekom = new \CURLFile($srt_rekom_tmp, $srt_rekom_type, $srt_rekom_name);
            return $this->filesrtrekom = $filesrtrekom;
        }

    }

    public function getSk($sk_name, $sk_type, $sk_size, $sk_tmp)
    {
        $this->status = true;
        switch (empty($sk_name)) {
            case true:
                $this->message['getSk'] = "<font color=red><b>Upload dulu scan/foto Sk Pengangkatan anda</b></font>";
                break;
            default:
                $this->message['getSk'] = null;
                $this->status = false;
                break;
        }

        if (!$this->status) {
            $filesk = new \CURLFile($sk_tmp, $sk_type, $sk_name);
            return $this->filesk = $filesk;
        }
    }

    public function getImgTtd($img_ttd_name, $img_ttd_type, $img_ttd_size, $img_ttd_tmp)
    {
        $this->status = true;
        switch (empty($img_ttd_name)) {
            case true:
                $this->message['getImgTtd'] = "<font color=red><b>Upload dulu image ttd anda</b></font>";
                break;
            default:
                $this->message['getImgTtd'] = null;
                $this->status = false;
                break;
        }
        if (!$this->status) {
            $fileimgttd = new \CURLFile($img_ttd_tmp, $img_ttd_type, $img_ttd_name);
            return $this->fileimgttd = $fileimgttd;
        }
    }

}

?>

<!-- <form name="file_up" action="" method="POST" enctype="multipart/form-data">
Upload your file here<br><br><br>
    file KTP <br><input type="file" class="file" name="ktp" id="ktp"/><br><hr>
    file Surat Rekom <br><input type="file" class="file" name="srt_rekom" id="srt_rekom"/><br><hr>
    file SK <br><input type="file" class="file" name="sk" id="sk"/><br><hr>
    file Image TTD <br><input type="file" class="file" name="img_ttd" id="img_ttd"/><br><hr>

    <input type="submit" name="action" value="submit"/>
</form> -->
