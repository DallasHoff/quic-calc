<?php
$db_hn = getenv('DB_HN');
$db_db = getenv('DB_DB');
$db_un = getenv('DB_UN');
$db_pw = getenv('DB_PW');

$db_conn = new mysqli($db_hn, $db_un, $db_pw, $db_db);
if ($db_conn->connect_error) {
    die($db_conn->connect_error);
}
