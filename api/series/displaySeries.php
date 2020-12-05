<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);

$stmt = $items->getSeries();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $seriesArr = array();
    $seriesArr["body"] = array();
    $seriesArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "UID" => $UID,
            "Title" => $Title,
            "Description" => $Description,
            "Chapters" => $Chapters,
            "Image" => $Image,
            "Folder" => $Folder);

        array_push($seriesArr["body"], $e);
    }
    echo json_encode($seriesArr);
} else {
    http_response_code(204);
    print_r(array("message" => "No series found"));
}