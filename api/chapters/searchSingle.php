<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);
$items->ChNum = isset($_GET['chnum']) ? $_GET['chnum'] : die();
$items->Series = isset($_GET['series']) ? $_GET['series'] : die();
$items->searchSingle();

if ($items->Title != null) {
    // Create Array
    $emp_arr = array(
        "UID" => $items->UID,
        "ChNum" => $items->ChNum,
        "Series" => $items->Series,
        "Title" => $items->Title,
        "Pages" => $items->Pages,
        "Folder" => $items->Folder,
        "SeriesFolder" => $items->ExistingFolder);

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(204);
    print_r("Series not found.");
}