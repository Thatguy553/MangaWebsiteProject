<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);
$items->UID = isset($_GET['UID']) ? $_GET['UID'] : die();
$items->search();

if ($items->Title != null) {
    // Create Array
    $emp_arr = array(
        "UID" => $items->UID,
        "Title" => $items->Title,
        "Description" => $items->Description,
        "Chapters" => $items->Chapters,
        "Image" => $items->Image,
        "Folder" => $items->Folder
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(204);
    echo json_encode(["series" => "not_found"]);
}