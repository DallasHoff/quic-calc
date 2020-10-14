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