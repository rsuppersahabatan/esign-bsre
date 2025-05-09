<?php

namespace Esign;

// Ensure the file containing the listUser class is included if not autoloaded
require_once __DIR__ . '/API/listUser.php';

use downloadDokumen\downloadDokumen;
use listUser\listUser;
use API\registrasiUser; // Adjusted namespace to match the file structure
use sendSignRequest\sendSignRequest;
use signDokumenDownload\signDokumenDownload;
use signDokumen\signDokumen;
use verifyDokumen\VerifyDokumen;

class Esign
{

    public $proxy_host;
    public $proxy_port;

    public function __construct($proxy_host = null, $proxy_port = null)
    {
        $this->proxy_host = $proxy_host;
        $this->proxy_port = $proxy_port;
    }

    public function index()
    {
        // echo $this->proxy_host."<br>";
        // echo $this->proxy_port;
        $view = "<div style='margin-top:100px;text-align : center;font-size:2.4em'>Welcome to Esign Library, API Service from BSRE</div>";
        $view .= "<br><img src='https://bssn.go.id/wp-content/uploads/2017/09/logo-bsre.png' width='500' height='250' style='display: block;margin-left: auto;margin-right: auto;'>";
        $view .= "<br><hr>";
        $view .= "<h4 style='text-align : center; padding:0'>&copy; Rio Firmansyah Eka Saputra </h4>";
        $view .= "<hr>";
        return $view;

    }

    public function listUser()
    {
        require_once "API/listUser.php";
        $listUser = new listUser();
        return $listUser->index();
        // echo "listuser";
    }

    public function registrasiUser()
    {
        $error_ktp = "";
        $error_suratrekom = "";
        $error_sk = "";
        $error_imagettd = "";

        require_once "API/registrasiUser.php";
        $registrasiUser = new registrasiUser();

        $ktp_name = $_FILES["ktp"]["name"];
        $ktp_type = $_FILES["ktp"]["type"];
        $ktp_size = $_FILES["ktp"]["size"];
        $ktp_tmp = $_FILES["ktp"]["tmp_name"];

        $srt_rekom_name = $_FILES["suratrekom"]["name"];
        $srt_rekom_type = $_FILES["suratrekom"]["type"];
        $srt_rekom_size = $_FILES["suratrekom"]["size"];
        $srt_rekom_tmp = $_FILES["suratrekom"]["tmp_name"];

        $sk_name = $_FILES["skpengangkat"]["name"];
        $sk_type = $_FILES["skpengangkat"]["type"];
        $sk_size = $_FILES["skpengangkat"]["size"];
        $sk_tmp = $_FILES["skpengangkat"]["tmp_name"];

        $img_ttd_name = $_FILES["imagettd"]["name"];
        $img_ttd_type = $_FILES["imagettd"]["type"];
        $img_ttd_size = $_FILES["imagettd"]["size"];
        $img_ttd_tmp = $_FILES["imagettd"]["tmp_name"];

        // $_SESSION['imgArrayFile'][] = $_FILES['ktp']; //Your file informations
        // $_SESSION['obj_image_session'][] = !empty($_FILES['ktp']['tmp_name']) ? file_get_contents($_FILES['ktp']['tmp_name']) : null;

        // echo $_SESSION['imgArrayFile']['0']['name'];die();

        // =============================================================
        // Panggil dari Library
        $registrasiUser->getKtp($ktp_name, $ktp_type, $ktp_size, $ktp_tmp);
        $registrasiUser->getsrtRekom($srt_rekom_name, $srt_rekom_type, $srt_rekom_size, $srt_rekom_tmp);
        $registrasiUser->getSk($sk_name, $sk_type, $sk_size, $sk_tmp);
        $registrasiUser->getImgTtd($img_ttd_name, $img_ttd_type, $img_ttd_size, $img_ttd_tmp);

        $error_ktp = $registrasiUser->message['getKtp'];
        $error_suratrekom = $registrasiUser->message['getsrtRekom'];
        $error_sk = $registrasiUser->message['getSk'];
        $error_imagettd = $registrasiUser->message['getImgTtd'];

        $error_arr = array(
            'error_ktp' => $error_ktp,
            'error_suratrekom' => $error_suratrekom,
            'error_sk' => $error_sk,
            'error_imagettd' => $error_imagettd,
        );

        $_SESSION['error_message'] = $error_arr;

        return $registrasiUser->index();
    }

    public function sendSignRequest($file_name, $file_tmp)
    {
        $file = "";

        require_once "API/sendSignRequest.php";
        $sendSignRequest = new sendSignRequest();

        // $file_name = "D:\Dokumen\lamaran.pdf";
        // $file_name = $_FILES["file"]["name"];
        // $file_type = $_FILES["file"]["type"];
        // $file_size = $_FILES["file"]["size"];
        // $file_tmp = $_FILES["file"]["tmp_name"];

        // === Contoh Penggunaan ====================================
        // $file_name = "BPJS.pdf";
        $file_type = "application/pdf";
        // $file_tmp = "D:\BPJS.pdf";
        $file_size = "5000";
        // ==========================================================

        // die(json_encode($_FILES));

        // echo json_encode($sendSignRequest->getFile($file_name, $file_type, $file_size, $file_tmp));die;
        $sendSignRequest->getFile($file_name, $file_type, $file_size, $file_tmp);
        $error_file = $sendSignRequest->message['getFile'];
        $err_arr = array(
            'error_file' => $error_file,
        );

        $_SESSION['error_message'] = $err_arr;

        return $sendSignRequest->index();

    }

    public function signDokumen($id_signed)
    {

        require_once "API/signDokumen.php";
        $signDokumen = new signDokumen();

        return $signDokumen->index($id_signed);
    }

    public function downloadDok($id_signed, $file_name) 
    {

        require_once "API/downloadDokumen.php";
        $downloadDok = new downloadDokumen();

        return $downloadDok->index($id_signed, $file_name);
    }

    public function signDokumenDownload($id_signed, $file_name)
    {

        require_once "API/signDokumenDownload.php";
        $signDokumen = new signDokumenDownload();

        return $signDokumen->index($id_signed, $file_name);
    }

    public function verifyDokumen($file_name, $file_tmp)
    {

        $file = "";

        require_once "API/VerifyDokumen.php";
        $verifyDokumen = new VerifyDokumen();

        // $file_name = "D:\Dokumen\lamaran.pdf";
        // $file_name = $_FILES["file"]["name"];
        // $file_type = $_FILES["file"]["type"];
        // $file_size = $_FILES["file"]["size"];
        // $file_tmp = $_FILES["file"]["tmp_name"];

        // === Contoh Penggunaan ====================================
        // $file_name = "BPJS.pdf";
        $file_type = "application/pdf";
        // $file_tmp = "D:\BPJS.pdf";
        $file_size = "5000";
        // ==========================================================

        // die(json_encode($_FILES));

        // echo json_encode($sendSignRequest->getFile($file_name, $file_type, $file_size, $file_tmp));die;
        $verifyDokumen->getSignedFile($file_name, $file_type, $file_size, $file_tmp);
        $error_file = $verifyDokumen->message['getFile'];
        $err_arr = array(
            'error_file' => $error_file,
        );

        $_SESSION['error_message'] = $err_arr;

        return $verifyDokumen->index();
    }

}
