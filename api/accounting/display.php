<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/accounting.php';

$db = new Database();
$conn = $db->connect();

$items = new Accounting($conn);

$stmt = $items->display();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $userArr = array();
    $userArr["body"] = array();
    $userArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "UID" => $row['UID'],
            "User" => $row['username'],
            "Created" => $row['created'],
            "Role" => $row['role'],
            "API" => $row['APIAccess'],
            "Key" => $row['APIKey']);

        array_push($userArr["body"], $e);
    }
    echo json_encode($userArr);
} else {
    http_response_code(204);
    print_r(array("message" => "No users found"));
}