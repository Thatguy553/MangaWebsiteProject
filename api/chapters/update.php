<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}
// DB and Series class include
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

// Class Initialization
$db = new Database();
$conn = $db->connect();
$items = new Chapters($conn);

// Variables Assigned for series class via POST
$items->UID = $_POST['uid'];
$items->ChNum = $_POST['chnum'];
$items->Title = $_POST['title'];

if ($items->update()) {
    echo json_encode(["chapter" => "updated"]);
} else {
    echo json_encode(["chapter" => "error"]);
}