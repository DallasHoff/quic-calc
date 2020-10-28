<?php

require_once 'database.php';


function log_action($action, $category = NULL, $value = NULL) {
    global $db_conn;
    if (!isset($action)) return;

    $logQuery = 'insert into action_log (action, category, value) values (?, ?, ?);';
    $logStatement = $db_conn->prepare($logQuery);
    $logStatement->bind_param('sss', $action, $category, $value);

    $logStatement->execute();
    $logStatement->close();
}

function delete_action($id) {
    global $db_conn;
    if (!isset($id)) return;

    $logQuery = 'delete from action_log where id=?;';
    $logStatement = $db_conn->prepare($logQuery);
    $logStatement->bind_param('i', $id);

    $logStatement->execute();
    $logStatement->close();
}


// API
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {

        case 'POST':
            $logAction = $_POST['action'];
            $logCategory = $_POST['category'];
            $logValue = $_POST['value'];

            if (!isset($logAction)) {
                echo 'Parameter "action" is required.';
                http_response_code(400);
                exit();
            }

            log_action($logAction, $logCategory, $logValue);
            echo 'Logged successfully.';
            http_response_code(200);
            exit();


        case 'DELETE':
            $logId = $_GET['id'];

            if (!isset($logId) || !is_numeric($logId)) {
                echo 'Parameter "id" must be an integer ID number.';
                http_response_code(400);
                exit();
            }

            $idInt = intval($logId);
            delete_action($idInt);
            echo 'Log item deleted successfully.';
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
