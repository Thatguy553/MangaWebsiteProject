<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);

$data = json_decode(file_get_contents("php://input"));

# $items->UID = $data->UID;
$items->Title = $data->Title;
$items->Description = $data->Description;
$items->Chapters = $data->Chapters;

if ($items->insert()) {
    echo "Series Successfully Created";
} else {
    echo "Series Could not be Created";
}
?>