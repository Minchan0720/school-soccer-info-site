<?php

// 데이터 읽기
$data = file_get_contents('data.json');

// POST 요청 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 수정된 데이터 저장
    $newData = $_POST['jsonData'];
    file_put_contents('data.json', $newData);
    
    // 변경된 데이터 출력
    echo "데이터가 성공적으로 수정되었습니다.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>/ DB Master | 재고관리시스템</title>
</head>
<body>

<h1>/ DB Master | 재고관리시스템</h1>

<form method="post">
    <textarea name="jsonData" rows="10" cols="50"><?php echo $data; ?></textarea><br><br>
    <input type="submit" value="저장">
</form>

</body>
</html>
