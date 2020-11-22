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

$items->UID = $data->UID;

if ($items->delete()) {
    echo json_encode("Series Deleted.");
} else {
    echo json_encode("Series could not be Deleted.");
}