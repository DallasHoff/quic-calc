<?php

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {

        case 'GET':
            // TODO
            http_response_code(501);
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
