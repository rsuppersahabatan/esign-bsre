<?php
namespace Endpoint;
use ModelDownloadDok\downloadDok;

class Endpoint
{

// $API_NAME = $_POST['API_NAME'];
    public $id_signed;

    public function __construct()
    {

    }
    public function getFullName($API_NAME)
    {

        require "env.php";
        $client_id = $env['client_id'];
        $client_secret = $env["client_secret"];
        $url = $env["url"];

        // ====================================================
        $username = $env["username"];

        // ====== Untu yg POST ini digunakan saat username
        // ====== dipanggil dari tabel simpeg dengan kolom NIK

        // $username = $_POST["username"];

        // ====================================================

        $FULL_URL = "";
        $err_post = array();

        switch ($API_NAME) {
            case 'get_access_token':

                $FULL_URL = $url . "/oauth/token?";
                $FULL_URL .= "client_id=$client_id";
                $FULL_URL .= "&client_secret=$client_secret";
                $FULL_URL .= "&grant_type=client_credentials";
                break;

            case 'registrasi_user':

                $nik = isset($_POST['nik']) ? $_POST['nik'] :
                $err_post['nik'] = "Error : nik harus di deklarasikan";

                $nama = $_POST['nama'];
                $nip = $_POST['nip'];
                $email = $_POST['email'];
                $jabatan = $_POST['jabatan'];
                $nomor_telepon = $_POST['nomor_telepon'];
                $unit_kerja = $_POST['unit_kerja'];
                $kota = $_POST['kota'];
                $provinsi = isset($_POST['provinsi']) ? $_POST['provinsi'] :
                $err_post['provinsi'] = "Error : provinsi harus di deklarasikan";

                $FULL_URL = $url . "/api/v2/entity/registrasi?";
                $FULL_URL .= "nik=$nik";
                $FULL_URL .= "&nama=$nama";
                $FULL_URL .= "&nip=$nip";
                $FULL_URL .= "&email=$email";
                $FULL_URL .= "&jabatan=$jabatan";
                $FULL_URL .= "&nomor_telepon=$nomor_telepon";
                $FULL_URL .= "&unit_kerja=$unit_kerja";
                $FULL_URL .= "&kota=$kota";
                $FULL_URL .= "&provinsi=$provinsi";
                break;

            case 'send_sign_request':

                // $penandatangan = $username;
                $penandatangan = $_POST['penandatangan'];
                
                $tujuan = $_POST['tujuan'];
                $perihal = $_POST['perihal'];
                $info = $_POST['info'];
                $jenis_dokumen = $_POST['jenis_dokumen'];
                $nomor = $_POST['nomor'];
                $tampilan = $_POST['tampilan'];
                $image = $_POST['image'];
                $linkQR = $env["linkQR"];
                // $linkQR = $_POST["linkQR"];
                $halaman = $_POST["halaman"];
                $yAxis = $_POST["yAxis"];
                $xAxis = $_POST["xAxis"];
                $width = $_POST["width"];
                $height = $_POST["height"];

                $arr_param_send_sign = array(
                    'tujuan' => $tujuan,
                    'perihal' => $perihal,
                    'info' => $info,
                    'jenis_dokumen' => $jenis_dokumen,
                    'nomor' => $nomor,
                    'tampilan' => $tampilan,
                    'image' => $image,
                    'halaman' => $halaman,
                    'yAxis' => $yAxis,
                    'xAxis' => $xAxis,
                    'width' => $width,
                    'height' => $height);

                $_SESSION['send_sign'] = $arr_param_send_sign;

                $FULL_URL = $url . "/api/v2/entity/sign/request?";
                $FULL_URL .= "penandatangan=$penandatangan";
                $FULL_URL .= "&tujuan=$tujuan";
                $FULL_URL .= "&perihal=$perihal";
                $FULL_URL .= "&info=$info";
                $FULL_URL .= "&jenis_dokumen=$jenis_dokumen";
                $FULL_URL .= "&nomor=$nomor";
                // Tampilan = ( invisible /  visible )
                $FULL_URL .= "&tampilan=$tampilan";
                $FULL_URL .= "&image=$image";
                $FULL_URL .= "&linkQR=$linkQR";
                // Halaman = (pertama / terakhir )
                $FULL_URL .= "&halaman=$halaman";

                // yAxis -> height = satuan px
                $FULL_URL .= "&yAxis=$yAxis";
                $FULL_URL .= "&xAxis=$xAxis";
                $FULL_URL .= "&width=$width";
                $FULL_URL .= "&height=$height";
                break;

            case 'download_dokumen':
                // $id_signed = $_POST['id_signed'];
                $id_signed = $this->id_signed;
                $FULL_URL = $url . "/api/v2/entity/sign/download/$id_signed";

                break;

            case 'sign_dokumen':

                $passphrase = $_POST['passphrase'];
                // $id_signed = $_POST['id_signed'];
                $id_signed = $this->id_signed;
                $FULL_URL = $url . "/api/v2/entity/sign/$id_signed?";
                $FULL_URL .= "passphrase=$passphrase";
                $FULL_URL .= "&approved_info=ok";

                break;

            case 'verify_dokumen':

                $FULL_URL = $url . "/api/v2/entity/verify/";

                break;

            case 'list_user':

                $FULL_URL = $url . "/api/v2/entity/users";

                break;

            case 'update_tampilan_ttd':

                $tampilan = $_POST['tampilan'];
                $image = $_POST['image'];

                // ===================================
                $linkQR = $env["linkQR"];
                // $linkQR = $_POST["linkQR"];
                // ===================================

                $halaman = $_POST["pertama"];
                $yAxis = $_POST["yAxis"];
                $xAxis = $_POST["xAxis"];
                $id_signed = $_POST['id_signed'];

                $FULL_URL = $url . "/api/v2/entity/sign/update/properties/$id_signed?";
                $FULL_URL .= "tampilan=$tampilan";
                $FULL_URL .= "&image=$image";
                $FULL_URL .= "&halaman=$halaman";
                $FULL_URL .= "&yAxis=$yAxis";
                $FULL_URL .= "&xAxis=$xAxis";
                $FULL_URL .= "&linkQR=$linkQR";

                break;

            case 'update_dokumen':

                $penandatangan = $username;
                $tujuan = $_POST['tujuan'];
                $perihal = $_POST['perihal'];
                $info = $_POST['info'];
                $jenis_dokumen = $_POST['jenis_dokumen'];
                $nomor = $_POST['nomor'];
                $id_signed = $_POST['id_signed'];

                $FULL_URL = $url . "/api/v2/entity/sign/update/doc/$id_signed?";
                $FULL_URL .= "penandatangan=$username";
                $FULL_URL .= "&tujuan=$tujuan";
                $FULL_URL .= "&perihal=$perihal";
                $FULL_URL .= "&info=$info";
                $FULL_URL .= "&jenis_dokumen=$jenis_dokumen";
                $FULL_URL .= "&nomor=$nomor";

                break;

            case 'ubah_data_email_dll':

                $nama = $_POST['nama'];
                $nip = $_POST['nip'];
                $email = $_POST['email'];
                $jabatan = $_POST['jabatan'];
                $nomor_telepon = $_POST['nomor_telepon'];
                $unit_kerja = $_POST['unit_kerja'];
                $kota = $_POST['kota'];
                $provinsi = $_POST['provinsi'];

                $FULL_URL = $url . "/api/v2/entity/profile/$username?";
                $FULL_URL .= "nama=$nama";
                $FULL_URL .= "&nip=$nip";
                $FULL_URL .= "&email=$email";
                $FULL_URL .= "&jabatan=$jabatan";
                $FULL_URL .= "&nomor_telepon=$nomor_telepon";
                $FULL_URL .= "&unit_kerja=$unit_kerja";
                $FULL_URL .= "&kota=$kota";
                $FULL_URL .= "&provinsi=$provinsi";

                break;

            case 'ubah_pin':

                $FULL_URL = $url . "/api/v2/entity/pin/ubah/$username";

                break;

            case 'reset_pin':

                $FULL_URL = $url . "/api/v2/entity/pin/reset/$username";

                break;

            default:
                return "tidak ada API yang dipilih";
                break;

        }
        return $FULL_URL;
    }

}
