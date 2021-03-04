<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$acc = new Accounting($conn);

$data = json_decode(file_get_contents("php://input"));

$acc->username = $data->username;
$acc->password = $data->password;

if ($result = $acc->login()) {
    session_start();
    $_SESSION['UID'] = $result['UID'];
    $_SESSION['user'] = $result['username'];
    $_SESSION['API'] = $result['APIAccess'];
    $_SESSION['Key'] = $result['APIKey'];
    $_SESSION['created'] = $result['created'];
    $_SESSION['role'] = $result['role'];
    $_SESSION['logout'] = "'false'";
    $sessionArr = $_SESSION;
    echo json_encode($sessionArr);
} else {
    echo json_encode(['login' => 'failed']);
}