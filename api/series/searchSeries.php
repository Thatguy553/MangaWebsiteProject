<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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
        "Folder" => $items->Folder);

    http_response_code(200);
    print_r($emp_arr);
} else {
    http_response_code(404);
    print_r("Series not found.");
}