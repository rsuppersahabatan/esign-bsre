<?php
// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$env = array();

// Digunakan untuk parameter dalam environment dan
// penggunaanya untuk semua API

// Url diambil dari server dev dan prod dari pihak bssn
$env["url"] = "https://esign-dev.bssn.go.id";

$env["linkQR"] = "http://siktln.kemensetneg.go.id/doc";

$env["client_id"] = "16314426";

$env["client_secret"] = "39j1-sifb-del9-3cg6";


// param username adalah nik yang kita daftarkan atas nama badan terkait
$env["username"] = "1715021915689";
// $env["username"] = "17150219185233";

$env["reload_page"] = "<script> window.location.reload(); </script>";


// param password adalah hasil dari persetujuan pihak
// BSRE dari hasil registrasi lalu dikirim via email dan
// biasanya akan masuk di spam email
$env["password"] = "5vm7p2v4";

$env["proxy"] = "10.15.3.21:80";
// $env["proxy"] = "";


