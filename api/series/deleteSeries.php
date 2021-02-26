<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);

$items->UID = $_POST['uid'];

if ($items->delete()) {
    echo json_encode(["series" => "deleted"]);
} else {
    echo json_encode(["series" => "error"]);
}