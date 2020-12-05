<?php
// CORS Stuff
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// DB and Series class include
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

// Class Initialization
$db = new Database();
$conn = $db->connect();
$items = new Chapters($conn);

// Variables Assigned for series class via POST
$items->UID = $_POST['uid'];
$items->ChNum = $_POST['chnum'];
$items->Title = $_POST['title'];

if ($items->update()) {
    print_r("Series data updated.");
} else {
    print_r("Series data could not be updated.");
}