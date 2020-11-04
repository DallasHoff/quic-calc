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


$cookie = 'mem';
$memVal = isset($_COOKIE[$cookie]) ? floatval($_COOKIE[$cookie]) : 0;
$cookieExpiry = time() + 86400;

switch ($method) {

    case 'GET':
        echo $memVal;
        http_response_code(200);
        exit();


    case 'PUT':
        parse_str(file_get_contents('php://input'), $put);
        $val = $put['value'];

        if (!isset($val)) {
            echo 'Please use the "value" parameter to specify the amount to add to the memory value.';
            http_response_code(400);
            exit();
        }

        $newVal = $memVal + floatval($val);
        setcookie($cookie, $newVal, $cookieExpiry);
        echo $newVal;
        http_response_code(200);
        exit();


    case 'DELETE':
        setcookie($cookie, '', -1);
        echo 'Memory reset';
        http_response_code(200);
        exit();


    case 'HEAD':
        http_response_code(200);
        exit();


    default:
        http_response_code(405);
        exit();
        

}