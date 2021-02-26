<?php

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();

$items = new Chapters($conn);
$items->Folder = $_POST['cfolder'];
$items->ExistingFolder = $_POST['sfolder'];
$pages = $items->pageArr();
if (count($pages) > 0) {
    $pagesArr = array();
    $pagesArr["body"] = array();
    $pageNum = count($pages);

    $i = 0;
    while ($pageNum > 0) {
        extract($pages);
        $e = array(
            "Page" => $pages[$i],
        );

        array_push($pagesArr["body"], $e);
        $pageNum = $pageNum - 1;
        $i = $i + 1;
    }
    echo json_encode($pagesArr);
} else {
    http_response_code(204);
    echo json_encode(["chapter" => "not_found"]);
}