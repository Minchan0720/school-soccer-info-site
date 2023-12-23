<?php
require_once 'aes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = 'iU6PYM0YdAqwD4M';

    $users_file = __DIR__ . '/users.json';
    $users_data = file_get_contents($users_file);
    $users = json_decode($users_data, true);

    $user_username = $_POST['username'] ?? '';
    $user_password = $_POST['password'] ?? '';

    $stayLoggedIn = isset($_POST['stayLoggedIn']) && $_POST['stayLoggedIn'] == 'on';

    $authenticated = false;
    foreach ($users as $user) {
        $decrypted_password = decryptData($user['password'], $key);

        if ($user['username'] === $user_username && $decrypted_password === $user_password) {
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user_username;
        $_SESSION['encrypted_name'] = $user['name'];
        $_SESSION['point'] = $user['point'];

        if ($stayLoggedIn) {
            setcookie('username', $user_username, time() + 60 * 60 * 24 * 30);
            setcookie('session_key', session_id(), time() + 60 * 60 * 24 * 30);
            setcookie('encrypted_name', $user['name'], time() + 60 * 60 * 24 * 30); // encrypted_name 쿠키 추가
            setcookie('point', $user['point'], time() + 60 * 60 * 24 * 30); // point 쿠키 추가
        }
        header('Location: /ve_index.php');
        exit;
    } else {
        header('Location: /login/login_view.php?error=failed');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>로그인</title>
  <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
        }
        .form-container {
            max-width: 480px;
            margin: 40px auto;
        }
        .form-group {
            margin: 20px 0;
        }
        .form-control, .btn {
            font-size: 18px;
            padding: 12px 20px;
            border-radius: 25px;
        }
        .form-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .title {
            font-family: 'Gaesegi', cursive;
            font-size: 40px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <h1 class="title h3 mb-3 fw-normal text-center">Noisy IT 로그인</h1>
            <form method="post">
                <div class="form-group">
                    <div style="display: flex; align-items: center;">
                        <input type="text" id="username" name="username" class="form-control" placeholder="학번" required style="
                            background-image: url('/img/profile-icon.png');
                            background-repeat: no-repeat;
                            background-position: 10px center;
                            background-size: 30px 30px;  
                            padding-left: 50px;
                        ">
                    </div>
                </div>
                <div class="form-group">
                    <div style="display: flex; align-items: center; position: relative;">
                        <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required style="
                            background-image: url('/img/pss-icon.png');
                            background-repeat: no-repeat;
                            background-position: 10px center;
                            background-size: 30px 30px;  
                            padding-left: 50px;
                        ">
                        <img src="/img/password-view.png" alt="" id="togglePassword" style="
                            position:absolute;
                            right:10px;
                            height:20px;
                        " onclick="
                            var passwordInput = document.getElementById('password');
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                            } else {
                                passwordInput.type = 'password';
                            }
                        ">
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="stayLoggedIn" name="stayLoggedIn">
                        <label class="form-check-label" for="stayLoggedIn" style="color: black">로그인 상태 유지</label>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <img src="/img/galo_wh.png" alt="로고" style="max-width: 50%; height: auto;">
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #666;">로그인</button>
            </form>
            <div class="text-center mt-3">
                <a href="reset_view.php" style="color: black; text-decoration: underline;">비밀번호 찾기</a> |
                <a href="signup_view.php" style="color: black; text-decoration: underline;">회원 가입</a>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const loginError = urlParams.get('error');

            if (loginError === 'failed') {
                const errorMsg = '로그인 실패: 아이디 또는 비밀번호가 잘못되었습니다.';
                alert(errorMsg);
                // 회원가입 오류 메시지를 제거하려면 URL을 수정함 /lgi
                window.location.href = '/login/login_view.php';
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
