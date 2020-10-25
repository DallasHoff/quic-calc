<?php
require_once 'database.php';

function log_action($action, $category = NULL, $value = NULL) {
    global $db_conn;

    $logQuery = 'insert into action_log (action, category, value) values (?, ?, ?);';
    $logStatement = $db_conn->prepare($logQuery);
    $logStatement->bind_param('sss', $action, $category, $value);

    $logStatement->execute();
    $logStatement->close();
}


// API
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $logAction = $_POST['action'];
        $logCategory = $_POST['category'];
        $logValue = $_POST['value'];

        if (isset($logAction)) {
            log_action($logAction, $logCategory, $logValue);
            echo 'Logged successfully.';
            http_response_code(200);
            exit();
        } else {
            echo 'Parameter "action" is required.';
            http_response_code(400);
            exit();
        }

    default:
        http_response_code(501);
        exit();
}
