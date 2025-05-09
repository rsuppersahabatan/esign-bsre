<?php

namespace getAccessToken;

require_once realpath(__DIR__ . '/../path/to/Endpoint.php'); // Adjust the path to the actual location of Endpoint.php

use Endpoint\Endpoint;

class getAccessToken
{
    function __construct(){}

    public function index()
    {

        $endPoint = new Endpoint();
        require realpath(__DIR__ . '/..') ."/env.php";
        $url = $endPoint->getFullName("get_access_token");      
        $curl = curl_init();
        $proxy = $env["proxy"];
        $proxy = explode(':', $proxy);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PROXY => $proxy[0],
            CURLOPT_PROXYPORT => $proxy[1],
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 451314ae-10f8-7677-c9bf-0a85600b976c",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $data = json_decode($response);
        }

        $_SESSION["access_token"] = $data->access_token;
        $_SESSION["expired"] = $data->expires_in;

    }
}
