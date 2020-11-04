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

function read_log($action, $category, $id, $limit = 50) {
    global $db_conn;

    // 1=1 so that where clause cannot end up empty if no parameters are passed
    $logQuery = 'select * from action_log where 1=1';
    // Add conditions from parameters
    $paramTypes = '';
    $params = array();
    if (isset($action)) {
        $logQuery .= ' and action=?';
        $paramTypes .= 's';
        array_push($params, $action);
    }
    if (isset($category)) {
        $logQuery .= ' and category=?';
        $paramTypes .= 's';
        array_push($params, $category);
    }
    if (isset($id) && intval($id)) {
        $logQuery .= ' and id=?';
        $paramTypes .= 'i';
        array_push($params, intval($id));
    }
    $logQuery .= ' order by timestamp desc';
    if (intval($limit)) {
        $logQuery .= ' limit ?';
        $paramTypes .= 'i';
        array_push($params, intval($limit));
    }
    $logQuery .= ';';

    $logStatement = $db_conn->prepare($logQuery);
    $logStatement->bind_param($paramTypes, ...$params);
    
    $logStatement->execute();
	$logResult = $logStatement->get_result()->fetch_all(MYSQLI_ASSOC);
    $logStatement->close();
    return $logResult;
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
$headers = apache_request_headers();

// Auth
$authKey = $headers['x-api-key'];

if ($authKey !== 'demo') {
    echo 'Invalid API key. Please set your API key in the x-api-key header.';
    http_response_code(401);
    exit();
}


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


    case 'GET':
        $logAction = $_GET['action'];
        $logCategory = $_GET['category'];
        $logId = $_GET['id'];
        $logLimit = $_GET['limit'];

        if (isset($logId) && !is_numeric($logId)) {
            echo 'Parameter "id" must be an integer ID number.';
            http_response_code(400);
            exit();
        }
        if (isset($logLimit) && !is_numeric($logLimit)) {
            echo 'Parameter "limit" must be an integer ID number.';
            http_response_code(400);
            exit();
        }

        $logOutput = read_log($logAction, $logCategory, $logId, $logLimit);
        if (empty($logOutput)) {
            echo 'No matching log items were found.';
            http_response_code(404);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode($logOutput);
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
