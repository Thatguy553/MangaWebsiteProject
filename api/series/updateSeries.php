<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__.'/../../config/database.php';
include_once __DIR__.'/../../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);

$data = json_decode(file_get_contents("php://input"));

$items->UID = $data->UID;

// Series Values
$items->Title = $data->Title;
$items->Description = $data->Description;
$items->Chapters = $data->Chapters;

if ($items->update()) {
    echo json_encode("Series data updated.");
} else {
    echo json_encode("Series data could not be updated.");
}
?>