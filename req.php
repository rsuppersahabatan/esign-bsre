<?php

if (!isset($_SESSION)) session_start();

require_once "env.php";
require_once "endpoint.php";

$curl = curl_init();
$endPoint = new Endpoint\Endpoint();
$proxy = $env["proxy"];
$reload = $env["reload_page"];
$proxy = explode(':', $proxy);


if(!isset($_SESSION['access_token'])){
    require_once("API/getAccessToken.php");
    $getToken = new getAccessToken\getAccessToken();
    $getToken->index();  
}

$access_token = $_SESSION['access_token'];

