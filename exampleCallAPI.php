<?php
namespace callAPI;

use Esign\Esign;
require_once "esign.php";
$esign = new Esign();

error_reporting(~E_NOTICE);

// echo $esign->listUser()->index();

// $listUser = new listUser();
// $listUser = new registrasiUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $email = $_POST['email'];
    $jabatan = $_POST['jabatan'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $unit_kerja = $_POST['unit_kerja'];
    $kota = $_POST['kota'];
    $provinsi = $_POST['provinsi'];

    $arr_param_reg_user = [
        'nik' => $nik,
        'nama' => $nama,
        'nip' => $nip,
        'email' => $email,
        'jabatan' => $jabatan,
        'nomor_telepon' => $nomor_telepon,
        'unit_kerja' => $unit_kerja,
        'kota' => $kota,
        'provinsi' => $provinsi
    ];

    $registrasiUser = $esign->registrasiUser();
    if (is_object($registrasiUser) && method_exists($registrasiUser, 'index')) {
        $registrasiUser->index();
    } else {
        error_log("Error: registrasiUser() did not return a valid object or 'index' method is missing.");
    }

    unset($_SESSION['reg_user']);
    $_SESSION['reg_user'] = $arr_param_reg_user;

    //  echo json_encode($_SESSION['reg_user']) . "<br>";
    //         echo $_SESSION['reg_user']['kota'];die();
    // ============================================================
}
?>

<form name="file_up" action="" method="POST" enctype="multipart/form-data">
<table>
    <tr>
        <td>Nik</td>
        <td><input type="text" name="nik" id="nik" value="<?=$_SESSION['reg_user']['nik']?>"></td>

    </tr>
    <tr>
        <td>Nama</td>
        <td><input type="text" name="nama" id="nama" value="<?=$_SESSION['reg_user']['nama']?>"></td>
    </tr>
    <tr>
        <td>Nip</td>
        <td><input type="text" name="nip" id="nip" value="<?=$_SESSION['reg_user']['nip']?>"></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><input type="text" name="email" id="email" value="<?=$_SESSION['reg_user']['email']?>"></td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td><input type="text" name="jabatan" id="jabatan" value="<?=$_SESSION['reg_user']['jabatan']?>"></td>
    </tr>
    <tr>
        <td>Nomor Telepon</td>
        <td><input type="text" name="nomor_telepon" id="nomor_telepon" value="<?=$_SESSION['reg_user']['nomor_telepon']?>"></td>
    </tr>
    <tr>
        <td>Unit Kerja</td>
        <td><input type="text" name="unit_kerja" id="unit_kerja" value="<?=$_SESSION['reg_user']['unit_kerja']?>"></td>
    </tr>
    <tr>
        <td>Kota</td>
        <td><input type="text" name="kota" id="kota" value="<?=$_SESSION['reg_user']['kota']?>"></td>
    </tr>
    <tr>
        <td>Provinsi</td>
        <td><input type="text" name="provinsi" id="provinsi" value="<?=$_SESSION['reg_user']['provinsi']?>"></td>
    </tr>
</table>
<hr>
Upload your file here<br><br><br>

    file KTP <br><input type="file" class="file" name="ktp" id="ktp"/>
    <?=$_SESSION['err_file']['error_ktp']?>
    <br><hr>
    file Surat Rekom <br><input type="file" class="file" name="suratrekom" id="suratrekom"/>
    <?=$_SESSION['err_file']['error_suratrekom']?>
    <br><hr>
    file SK <br><input type="file" class="file" name="skpengangkat" id="skpengangkat"/>
    <?=$_SESSION['err_file']['error_sk']?>
    <br><hr>
    file Image TTD <br><input type="file" class="file" name="imagettd" id="imagettd"/>
    <?=$_SESSION['err_file']['error_imagettd']?>
    <br><hr>

    <input type="submit" name="action" value="submit"/>
</form>
