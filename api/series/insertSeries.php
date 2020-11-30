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

# $items->UID = $data->UID;
$items->Title = $_POST['title'];
$items->Description = $_POST['description'];
$items->Chapters = 0;
$items->Image = $_FILES['files'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];

        $file_name = $_FILES['files']['name'][0];
        $file_tmp = $_FILES['files']['tmp_name'][0];
        $file_type = $_FILES['files']['type'][0];
        $file_size = $_FILES['files']['size'][0];
        $file_ext = strtolower(end(explode('.', $file_name)));

        if (!in_array($file_ext, $extensions)) {
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        if ($file_size > 15000000) {
            $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }

// Moves file to folder
        if (empty($errors)) {
            $items->Image = $_FILES['files'];
            if ($items->insert()) {
                echo json_encode("Series Successfully Created");
            } else {
                echo json_encode("Series Could not be Created");
            }
        }

        if ($errors) {
            print_r($errors);
        }

    }
}