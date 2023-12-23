<?php
    session_start();

    if (isset($_SESSION['username'])) {
        $user_username = $_SESSION['username'];
    }

    require_once 'login/aes.php';
    $key = 'iU6PYM0YdAqwD4M';

    if (isset($_SESSION['encrypted_name'])) {
       $decrypted_name = decryptData($_SESSION['encrypted_name'], $key);
        $username_display = htmlspecialchars($decrypted_name) . "님";
    } else {
        $username_display = "Guest";
    }

    if (isset($_COOKIE['username']) && isset($_COOKIE['session_key'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $_COOKIE['username'];
        session_id($_COOKIE['session_key']);
    }

    // 관리자 시스템 패널도 가져오기 추가  
    $user_rank = isset($_SESSION['rank']) ? $_SESSION['rank'] : '';

    function get_user_points($username, $user_data) {
        foreach ($user_data as $user) {
            if ($user['username'] === $username) {
                return $user['point'];
            }
        }
        return 0;
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user_data = json_decode(file_get_contents('./login/users.json'), true);
        $points = get_user_points($username, $user_data);
    }
?>
