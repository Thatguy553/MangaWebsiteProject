<?php
$header = getallheaders();
if (!$header['api-key']) {
    print_r(["ERROR" => "ACCESS DENIED"]);
    exit;
}
// print_r($header);
// $url = 'http://localhost/api/verification.php';
// $json = json_encode(['Key' => $header['api-key'], 'UID' => $header['UID']]);

// $options = ['http' => [
//     'method' => 'POST',
//     'header' => 'Content-type:application/json',
//     'content' => $json,
// ]];

// $context = stream_context_create($options);
// $response = file_get_contents($url, false, $context);

// print_r($response);

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../class/chapters.php';

$db = new Database();
$conn = $db->connect();
$items = new Chapters($conn);

# $items->UID = $data->UID;
$items->Title = $_POST['title'];
$items->ChNum = $_POST['chnum'];
$items->Series = $_POST['series'];
$items->Rar = $_FILES['files'];
$items->ExistingFolder = $_POST['folder'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $extensions = ['zip', 'rar', '7z'];

        $file_name = $_FILES['files']['name'][0];
        $file_tmp = $_FILES['files']['tmp_name'][0];
        $file_type = $_FILES['files']['type'][0];
        $file_size = $_FILES['files']['size'][0];
        $file_ext_start = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext_start));

        if (!in_array($file_ext, $extensions)) {
            $errors["ext"] += 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }

        if ($file_size > 100000000) {
            $errors["file_size"] += 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }

        // Moves file to folder
        if (empty($errors)) {
            $items->Image = $_FILES['files'];
            if ($items->insert()) {
                echo json_encode(["chapter" => "created"]);
            } else {
                echo json_encode(["chapter" => "error"]);
            }
        }

        if ($errors) {
            echo json_encode($errors);
        }
    }
}