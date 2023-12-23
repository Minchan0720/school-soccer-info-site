<?php
session_start();

if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: /system/admin/admin_site.php');
    exit;
}
?>
<?php
require_once 'aes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetUsername = $_POST['target_username'];

    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as &$user) {
        if ($user['username'] === $targetUsername) {
            $resetCode = generateResetCode();
            $user['reset_code'] = $resetCode;

            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

            $resetLink = "www.noisyit.com/login/reset-password.php?username=$targetUsername&reset_code=$resetCode";

            $message =  $resetLink;
            sendDiscordNotification($message);

            echo "<div style='font-size: 16px; padding: 10px;'>비밀번호 재설정 링크:</div>";
            echo "<div style='font-size: 20px; font-weight: bold; padding: 10px;'><a href='$resetLink'>$resetLink</a></div>";
            exit;
        }
    }

    $message = "사용자를 찾을 수 없습니다.";
    sendDiscordNotification($message);

    echo "<div style='color: red; font-size: 16px; padding: 10px;'>사용자를 찾을 수 없습니다.</div>";
}

function generateResetCode() {
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function sendDiscordNotification($message) {
    $url = 'https://discord.com/api/webhooks/1143162029406961684/Ooj4jiei5tAMxZwP4hgaf1OogeFPoMJGKGT47gauFdb11R-PIFbnh_af8RGGiICZFmCh';

    $payload = json_encode(array('content' => $message));

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
?>
<?php
if (!isset($_COOKIE['noisy_web_pass'])) {
    header("Location: /index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>관리자 비밀번호 재설정</title>
</head>
<body>
    <h1 style='text-align: center;'>관리자 비밀번호 재설정</h1>
    <form method="post" style='text-align: center;'>
        <label for="target_username" style='font-size: 16px;'>대상 사용자 이름:</label>
        <input type="text" id="target_username" name="target_username" required style='padding: 5px; font-size: 16px;'><br><br>
        
        <button type="submit" style='padding: 8px 15px; font-size: 16px;'>비밀번호 재설정 링크 생성</button>
    </form>
</body>
</html>
