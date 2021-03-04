<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$items = new Accounting($conn);
$items->username = $_POST['username'];

$results = $items->search();

if ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    // Create Array
    $emp_arr = array(
        "UID" => $row['UID'],
        "User" => $row['username'],
        "Created" => $row['created'],
        "Role" => $row['role'],
        "API" => $row['APIAccess'],
        "Key" => $row['APIKey']
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    echo json_encode(["Results" => "No User Found"]);
    http_response_code(204);
}