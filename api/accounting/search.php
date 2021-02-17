<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$items = new Accounting($conn);
$items->UID = $_POST['UID'];

$items->search();

if ($items->UID != null) {
    // Create Array
    $emp_arr = array(
        "UID" => $items->UID,
        "User" => $items->username,
        "Created" => $items->created,
        "Role" => $items->role,
        "API" => $items->APIAccess,
        "Key" => $items->APIKey);

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    print_r("User not found.");
    http_response_code(204);
}