<?php
require_once 'aes.php';

$key = 'iU6PYM0YdAqwD4M';
$users_file = 'users.json';
$restricted_names_file = 'no_names.txt';

if (!file_exists($users_file)) {
    file_put_contents($users_file, json_encode([]));
}

$users_data = file_get_contents($users_file);
$users = json_decode($users_data, true);

if (!is_array($users) && !is_object($users)) {
    $users = [];
}

$user_username = $_POST['username'] ?? '';
$user_name = $_POST['name'] ?? '';
$user_password = $_POST['password'] ?? '';
$user_phone = $_POST['phone'] ?? '';

$restricted_names_data = file_get_contents($restricted_names_file); 
$restricted_names = explode(PHP_EOL, $restricted_names_data);

if (in_array($user_name, $restricted_names)) {
    header('Location: /login/signup_view.php?error=name_restricted');
    exit;
}

foreach ($users as $user) {
    if ($user['username'] === $user_username) {
        header('Location: /login/signup_view.php?error=username_taken');
        exit;
    }
}

if (empty($user_username) || empty($user_name) || empty($user_password) || empty($user_phone)) {
    header('Location: /login/signup_view.php');
    exit;
}

$new_user = [
    'username' => $user_username,
    'name' => encryptData($user_name, $key),
    'password' => encryptData($user_password, $key),
    'phone' => encryptData($user_phone, $key),
    'point' => 10000,
    'value' => 0,
    'value2' => 0,
    'rank' => 'user'
];

$users[] = $new_user;

file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));

header('Location: /login/login_view.php');
exit;
?>