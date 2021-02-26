<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);

$items->UID = $_POST['uid'];
$items->Folder = $_POST['folder'];
$items->Series = $_POST['series'];

if ($items->delete()) {
    echo json_encode(["chapter" => "deleted"]);
} else {
    echo json_encode(["chapter" => "error"]);
}