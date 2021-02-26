<?php
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
        "SeriesFolder" => $items->ExistingFolder
    );

    http_response_code(200);
    echo json_encode($emp_arr);
} else {
    http_response_code(204);
    echo json_encode(["chapter" => "not_found"]);
}