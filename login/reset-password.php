<?php
require_once 'aes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $resetCode = $_POST['reset_code'];
    $newPassword = $_POST['new_password'];

    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as &$user) {
        if ($user['username'] === $username && $user['reset_code'] === $resetCode) {
            $user['password'] = encryptData($newPassword, $username); // 암호화된 비밀번호 저장
            $user['reset_code'] = null;

            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
            echo "<script>alert('비밀번호가 성공적으로 변경되었습니다.')</script>"; // alert 창 띄우기
            header("Location: login_view.php"); // login_view.php로 redirect 시키기
            exit;
        }
    }

    echo "<script>alert('잘못된 정보입니다.')</script>"; // alert 창 띄우기
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
    <title>비밀번호 재설정</title>
    <style>
        body {
            background-color: #fff;
        }
        #container {
            border: 2px solid #000;
            border-radius: 10px;
            width: 40%;
            margin: 100px auto;
            padding: 20px;
            box-sizing: border-box;
        }
        label {
            display: block;
            margin: 10px 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #000;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #ccc;
            color: #000;
            border: 1px solid #000;
            padding: 5px 10px;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* 중앙 정렬 */
        form {
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1 style="text-align: center;">비밀번호 재설정</h1>
        <form method="post">
            <label for="username">사용자 이름:</label>
            <input type="text" id="username" name="username" required value="<?php echo $_GET['username']; ?>">

            <label for="reset_code">재설정 코드:</label>
            <input type="text" id="reset_code" name="reset_code" required value="<?php echo $_GET['reset_code']; ?>">

            <label for="new_password">새 비밀번호:</label>
            <input type="password" id="new_password" name="new_password" required>

            <button type="submit">저장하기</button>
        </form>
    </div>
</body>
</html>
