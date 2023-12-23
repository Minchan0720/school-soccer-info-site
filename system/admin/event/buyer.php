<?php
$message = $_POST['message'];

$jsonData = file_get_contents('buyer.json');
$data = json_decode($jsonData, true);

$data[] = $message;

$jsonDataUpdated = json_encode($data, JSON_PRETTY_PRINT);

file_put_contents('buyer.json', $jsonDataUpdated);
?>
