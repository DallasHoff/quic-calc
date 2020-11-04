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


try {
    switch ($method) {

        case 'GET':
            $op = $_GET['op'];
            $num1 = floatval($_GET['num1']);
            $num2 = floatval($_GET['num2']);
            $opsAllowed = array('add', 'subtract', 'multiply', 'divide', 'power');
            
            if (!isset($op) || !isset($num1) || !isset($num2)) {
                echo '"op", "num1", and "num2" are required parameters.';
                http_response_code(400);
                exit();
            }

            if (!in_array($op, $opsAllowed)) {
                echo 'Allowed values for "op" parameter are: "' . join('", "', $opsAllowed) . '"';
                http_response_code(400);
                exit();
            }

            $result = null;
            switch($op) {
                case 'add':
                    $result = $num1 + $num2;
                    break;
                case 'subtract':
                    $result = $num1 - $num2;
                    break;
                case 'multiply':
                    $result = $num1 * $num2;
                    break;
                case 'divide':
                    $result = $num1 / $num2;
                    break;
                case 'power':
                    $result = $num1 ** $num2;
                    break;
            }

            if (!isset($result)) {
                http_response_code(500);
                exit();
            }

            echo $result;
            http_response_code(200);
            exit();


        case 'HEAD':
            http_response_code(200);
            exit();


        default:
            http_response_code(405);
            exit();
            

    }
} catch (Exception $e) {
    http_response_code(500);
    exit();
}
