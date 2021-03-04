<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$acc = new Accounting($conn);

$data = json_decode(file_get_contents("php://input"));

$acc->username = $data->username;
$acc->password = $data->password;
$acc->role = "reader";

if ($result = $acc->signup()) {
    echo $result;
} else {
    echo $result;
}