<?php

$data = file_get_contents('../../login/users.json');
$password = "noisy2023web!!"; // 비밀번호 설정

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['jsonData']) && isset($_POST['password'])) {
        $newData = $_POST['jsonData'];
        $enteredPassword = $_POST['password']; // 입력된 비밀번호

        if ($enteredPassword === $password) { // 입력된 비밀번호가 일치하는 경우에만 데이터 저장
            file_put_contents('../../login/users.json', $newData);

            $data = $newData;
            echo "<script>alert('데이터가 성공적으로 수정되었습니다.');</script>";
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
        }
    } else {
        echo "<script>alert('입력된 데이터가 올바르지 않습니다.');</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<form method="post">
    <textarea name="jsonData" rows="10" cols="50"><?php echo $data; ?></textarea><br><br>
    비밀번호: <input type="password" name="password" required><br><br>
    <input type="submit" value="저장">
</form>

</body>
</html>
