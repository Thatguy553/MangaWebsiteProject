<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/series.php';

$db = new Database();
$conn = $db->connect();

$items = new Series($conn);

$items->UID = $_POST['uid'];

if ($items->delete()) {
    print_r("Series Deleted.");
} else {
    print_r("Series could not be Deleted.");
}