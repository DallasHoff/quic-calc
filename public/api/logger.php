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
$logAction = $_POST['action'];
$logCategory = $_POST['category'];
$logValue = $_POST['value'];

if (isset($logAction)) {
    log_action($logAction, $logCategory, $logValue);
    echo 'Logged Successfully';
}