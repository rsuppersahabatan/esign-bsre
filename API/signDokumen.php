<?php

namespace signDokumen;

use getAccessToken\getAccessToken;

class signDokumen
{

    public function __construct()
    {

    }

    public function index($id_signed)
    {
        require_once realpath(__DIR__ . '/..') . "/req.php";
        $endPoint->id_signed = $id_signed;
        $url = $endPoint->getFullName("sign_dokumen");
        $url = str_replace(" ", "%20", $url);
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
    
        return $response;
    }

    public function download_dokumen(){

       
    }
}
