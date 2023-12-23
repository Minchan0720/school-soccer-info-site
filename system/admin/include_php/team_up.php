<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>커뮤니티 설정</title>
</head>
<body>
    <div>
        <form method="POST">
            <input type="text" name="input1" placeholder="1학년부 대결 반" required><br>
            <input type="text" name="input2" placeholder="2학년부 대결 반" required><br>
            <input type="text" name="input3" placeholder="1st_2의 내용" required><br>
            <input type="text" name="input4" placeholder="2st_2의 내용" required><br>
            <button type="submit">저장</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input1 = $_POST['input1'];
        $input2 = $_POST['input2'];
        $input3 = $_POST['input3'];
        $input4 = $_POST['input4'];

        $data = array(
            "1st" => array(
                "1st_1" => $input1,
                "1st_2" => $input3
            ),
            "2st" => array(
                "2st_1" => $input2,
                "2st_2" => $input4
            )
        );

        $jsonFilePath = '/home/runner/Noisydev/comunity/1st.json'; // 절대 경로로 수정
        file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));
        echo "<script>alert('데이터가 수정되었습니다.');</script>";
    }
    ?>
</body>
</html>
