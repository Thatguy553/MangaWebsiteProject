<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);

$stmt = $items->display();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $seriesArr = array();
    $seriesArr["body"] = array();
    $seriesArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "UID" => $UID,
            "ChNum" => $ChNum,
            "Series" => $series,
            "Title" => $Title,
            "Pages" => $Pages,
            "Folder" => $Folder);

        array_push($seriesArr["body"], $e);
    }
    echo json_encode($seriesArr);
} else {
    http_response_code(204);
    print_r(array("message" => "No series found"));
}