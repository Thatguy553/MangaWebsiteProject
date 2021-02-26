<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$acc = new Accounting($conn);

$data = json_decode(file_get_contents("php://input"));

$acc->username = $data->username;
$acc->password = $data->password;

if ($acc->login()) {
    session_start();
    $_SESSION['UID'] = $acc->login()['UID'];
    $_SESSION['user'] = $acc->login()['user'];
    $_SESSION['API'] = $acc->login()['API'];
    $_SESSION['Key'] = $acc->login()['Key'];
    $_SESSION['role'] = $acc->login()['role'];
    return true;
} else {
    return false;
}