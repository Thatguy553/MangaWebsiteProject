<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__.'/../../config/database.php';
include_once __DIR__.'/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$acc = new Accounting($conn);

$data = json_decode(file_get_contents("php://input"));

$acc->username = $data->username;
$acc->password = $data->password;

if ($acc->login()) {
    session_start();
    $_SESSION['user'] = $acc->login()['user'];
    $_SESSION['role'] = $acc->login()['role'];
    return true;
} else {
    return false;
}