<?php

$product = $_POST['product'];

$data = json_decode(file_get_contents('data.json'), true);

if ($data[$product]['totalQuantity'] > 0 && $data[$product]['remainingSalesToday'] > 0) {
    $data[$product]['totalQuantity']--;
    $data[$product]['soldToday']++;
    $data[$product]['remainingSalesToday']--;
} else {
    echo "out of stock";
}

file_put_contents('data.json', json_encode($data));

?>
