<?php

namespace listUser;
use getAccessToken\getAccessToken;
class listUser
{
    public function __construct()
    {
        
    }

    public function index()
    {
        // require_once "../req.php";

        require_once realpath(__DIR__ . '/..') . "/req.php";
        $url = $endPoint->getFullName("list_user");

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
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $access_token",
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
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
    }
}
