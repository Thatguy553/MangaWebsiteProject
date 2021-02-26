<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}
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
        $file_ext_start = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext_start));

        if (!in_array($file_ext, $extensions)) {
            $errors["ext"] += 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        if ($file_size > 15000000) {
            $errors["fileSize"] += 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }

        // Moves file to folder
        if (empty($errors)) {
            $items->Image = $_FILES['files'];
            if ($items->insert()) {
                echo json_encode(["series" => "created"]);
            } else {
                echo json_encode(["series" => "error"]);
            }
        }

        if ($errors) {
            echo json_encode($errors);
        }
    }
}