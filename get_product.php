<?php
header('Content-Type: application/json');

$data = [
    'message' => 'Hello World',
    'status' => 'success'
];

echo json_encode($data);
?>
