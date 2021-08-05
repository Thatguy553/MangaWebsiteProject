<?php
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);

$stmt = $items->recents();
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
            "Pages" => $Pages,
            "ChNum" => $ChNum,
            "Folder" => $Folder,
            "Created" => $Created,
            "Series" => $series,
            "SeriesFolder" => $seriesFolder
        );

        array_push($seriesArr["body"], $e);
    }
    echo json_encode($seriesArr);
} else {
    http_response_code(204);
    echo json_encode(["recents" => "None"]);
}