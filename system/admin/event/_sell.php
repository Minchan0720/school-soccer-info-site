<?php


$users = json_decode(file_get_contents('../login/users.json'), true);
$data = json_decode(file_get_contents('data.json'), true);

$username = $_POST['username'];
$product = $_POST['product'];
$price = $_POST['price'];
  
foreach ($users as &$user) {
    if ($user['username'] == $username && $user['point'] >= $price && $data[$product]['remainingSalesToday'] > 0) {
        $user['point'] -= $price;
        $data[$product]['remainingSalesToday']--;
        
        file_put_contents('../login/users.json', json_encode($users));
        file_put_contents('data.json', json_encode($data));
        
        echo json_encode(['success' => true, 'remainingPoints' => $user['point']]);
        
        return;
    }
}

echo json_encode(['success' => false, 'error' => '판매 실패!']);

?>
