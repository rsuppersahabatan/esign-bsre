<?php
namespace verifyDokumen;

use getAccessToken\getAccessToken;

class VerifyDokumen
{

    public $file;
    public $status = true;

    public function __construct()
    {

    }

    public function index()
    {
        $response = "";
        if (!$this->status) {
            // require_once "../req.php";
            require_once realpath(__DIR__ . '/..') . "/req.php";
            $url = $endPoint->getFullName("verify_dokumen");

            $data = array(
                'signed_file' => $this->file,
            );

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_PROXY => $proxy[0],
                CURLOPT_PROXYPORT => $proxy[1],
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer $access_token",
                    "cache-control: no-cache",
                    "postman-token: 25085549-73c1-610d-a2df-ccf2114faa61",
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
                    require_once "getAccessToken.php";
                    $getToken = new getAccessToken();
                    $getToken->index();
                    echo $reload;
                } else {
                    return $response;
                }
            }
        } else {
            if (!isset($resp->SUMMARY)) {
                $response = json_encode(array("SUMMARY" => "tidak ada data"));
            }
            return $response;
        }
    }

    public function getSignedFile($file_name, $file_type, $file_size, $file_tmp)
    {
        $this->status = true;
        switch (empty($file_name)) {
            case true:
                $this->message['getFile'] = "<font color=red><b>Mohon upload File Dokumen Anda</b></font>";
                break;
            default:
                $this->message['getFile'] = null;
                $this->status = false;
                break;
        }

        if (!$this->status) {
            $file = new \CURLFile($file_tmp, $file_type, $file_name);
            return $this->file = $file;
        }

    }
}
