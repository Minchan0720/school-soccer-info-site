<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];
    $input3 = $_POST['input3'];
    $input4 = $_POST['input4'];

    $data = array(
        "1st" => array(
            "live_core1" => $input1,
            "live_core12" => $input3
        ),
        "2st" => array(
            "live_core2" => $input2,
            "live_core22" => $input4
        )
    );

    $jsonFilePath = '/home/runner/Noisydev/system/1nd2/live_core.json'; // 상대 경로로 수정
    file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode(['message' => '데이터가 수정되었습니다!']);
} else {
    http_response_code(405);
    echo json_encode(['message' => '잘못된 요청 메소드입니다.']);
}
?>
