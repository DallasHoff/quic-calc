<?php

$method = $_SERVER['REQUEST_METHOD'];
$headers = apache_request_headers();

// Auth
$authKey = $headers['x-api-key'];

if ($authKey !== 'demo') {
    echo 'Invalid API key. Please set your API key in the x-api-key header.';
    http_response_code(401);
    exit();
}


switch ($method) {

    case 'HEAD':
        http_response_code(200);
        exit();


    default:
        http_response_code(405);
        exit();
        

}