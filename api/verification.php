<?php

include __DIR__ . '/accounting/search.php';
include __DIR__ . '/../config/database.php';

// Database Connection
$db = new Database();
$conn = $db->connect();

// Accounting Class
$items = new Accounting($conn);

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Users Credentials
$items->UID = $data['UID'];

// search and compare
$items->search();

if ($items->search()['Key'] == $data['Key']) {
    echo "true";
} else {
    echo "false";
}