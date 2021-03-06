<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}
// DB and Series class include
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/series.php';

// Class Initialization
$db = new Database();
$conn = $db->connect();
$items = new Series($conn);

// Variables Assigned for series class via POST
$items->UID = $_POST['uid'];
$items->Description = $_POST['description'];
$items->Chapters = 0;
$items->Image = $_FILES['files'];
$items->ExistingImage = $_POST['EImage'];
$items->Folder = $_POST['folder'];

// Image Checks, Checks if the request method is post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Checks if a file was sent
    if (isset($_FILES['files'])) {
        $errors = [];
        $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_name = $_FILES['files']['name'][0];
        $file_tmp = $_FILES['files']['tmp_name'][0];
        $file_type = $_FILES['files']['type'][0];
        $file_size = $_FILES['files']['size'][0];
        $file_ext_start = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext_start));

        // Checks file extension is allowed
        if (!in_array($file_ext, $extensions)) {
            $errors["ext"] += 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        // Checks file is under size limit
        if ($file_size > 15000000) {
            $errors["fileSize"] += 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }

        // Sends data if there were no errors
        if (empty($errors)) {
            $items->Image = $_FILES['files'];
            if ($items->update()) {
                echo json_encode(["series" => "updated"]);
            } else {
                echo json_encode(["series" => "error"]);
            }
        }

        // Prints any errors to be picked up by fetch
        if ($errors) {
            echo json_encode($errors);
        }
    }
}