<?php
session_start();

function encrypt_data($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

function decrypt_data($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function log_visitor_info() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $time = time();
    $visitor_data = [
        'ip' => $ip,
        'browser' => $browser,
        'access_time' => $time
    ];

    $key = '1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    $encrypted_data = encrypt_data(json_encode($visitor_data), $key);
    $existing_logs = file_exists('anti_admin_user.json') ? json_decode(file_get_contents('anti_admin_user.json'), true) : [];
    $existing_logs[] = ['log' => $encrypted_data, 'time' => $time];
    file_put_contents('anti_admin_user.json', json_encode($existing_logs));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    log_visitor_info();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_pass = $_POST['input_password'];

    // 실제 비밀번호에서 입력받은 비밀번호 확인
    $stored_encrypted_password = json_decode(file_get_contents('anti_admin_code.json'))->password;
    $key = '1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    $stored_password = decrypt_data($stored_encrypted_password, $key);

    if ($input_pass === $stored_password) {
        $_SESSION['admin'] = true;
        header('Location: admin_site.php');
        exit;
    } else {
        $error_msg = "비밀번호가 일치하지 않습니다. 올바른 비밀번호를 확인해주세요.";
    }
}


function generate_password($length = 6) {
    return rand(pow(10, $length - 1), pow(10, $length) - 1);
}

function send_to_discord($message) {
    $webhook_url = 'https://discord.com/api/webhooks/1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    $json_data = json_encode([
        "content" => $message,
        "tts" => false,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

    $ch = curl_init($webhook_url);
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $json_data,
        CURLOPT_RETURNTRANSFER => true,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['issue_new_pass'])) {
    $new_pass = generate_password();
    $key = '1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    $encrypted_new_pass = encrypt_data((string)$new_pass, $key);
    file_put_contents('anti_admin_code.json', json_encode(['password' => $encrypted_new_pass]));
    send_to_discord("AdminCenter _ CODE : {$new_pass}");
    $success_msg = "새 암호가 발급되었습니다.";
}
?>


<!DOCTYPE html>
<html lang="ko">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>| 지원센터 관리자</title>
<head>
</head>
  <style>
            body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #e0e0e0;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
            width: 80%;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            outline: none;
            margin-top: 10px;
        }
        button {
            background-color: #7f7f7f;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            margin-top: 15px;
        }
        p {
            color: red;
            font-size: 14px;
        }
  </style>
<body>
    <div class="container">
        <?php if (isset($error_msg)): ?><p><?= $error_msg; ?></p><?php endif; ?>
        <?php if (isset($success_msg)): ?><p><?= $success_msg; ?></p><?php endif; ?>

        <h2>Noisy IT 지원센터</h2>
        <form method="post">
            <input type="password" name="input_password" placeholder="접속시 접속정보가 서버로 전달 됩니다.">
            <button type="submit" id="connect">Support Center</button>
            <button type="submit" name="issue_new_pass">ReSet MyAdminCode</button>
        </form>
    </div>
</body>
</html>
