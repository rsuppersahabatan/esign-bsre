<?php
namespace sendSignRequest;

use getAccessToken\getAccessToken;

class sendSignRequest
{
    public $file;
    public $message = array();
    public $prop = "";
    public $status = true;
    public $id_signed;

    public function __construct()
    {

    }

    public function index()
    {
        $response = "";
        if (!$this->status) {
            require_once realpath(__DIR__ . '/..') . "/req.php";
            $url = $endPoint->getFullName("send_sign_request");

            $url = str_replace(" ", "%20", $url);
            
            $data = array(
                'file' => $this->file,
            );

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

                $_SESSION['id_signed'] = isset($resp->id_signed) ? $resp->id_signed : "";

            }
        }

        return $response;
    }

    public function getFile($file_name, $file_type, $file_size, $file_tmp)
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

    /**
     * Get the value of id_signed
     */
    public function getId_signed()
    {
        return $this->id_signed;
    }

    /**
     * Set the value of id_signed
     *
     * @return  self
     */
    public function setId_signed($id_signed)
    {
        $this->id_signed = $id_signed;

    }
}
