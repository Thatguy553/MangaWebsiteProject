<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);
$items->UID = isset($_GET['series']) ? $_GET['series'] : die();
$stmt = $items->searchList();
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
            "Folder" => $Folder
        );

        array_push($seriesArr["body"], $e);
    }
    echo json_encode($seriesArr);
} else {
    http_response_code(204);
    echo json_encode(["chapter" => "not_found"]);
}