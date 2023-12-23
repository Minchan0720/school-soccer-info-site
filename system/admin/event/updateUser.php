<?php
if (isset($_POST['username']) && isset($_POST['point'])) {
    $username = $_POST['username'];
    $point = $_POST['point'];

    // users.json 파일의 절대 URL을 생성합니다.
    $usersJsonUrl = '../login/users.json';

    // users.json 파일을 읽어옵니다.
    $data = json_decode(file_get_contents($usersJsonUrl), true);

    foreach ($data as &$user) {
        if ($user['username'] === $username) {
            $user['point'] = $point;
            break;
        }
    }

    // 업데이트된 데이터를 users.json 파일에 저장합니다.
    file_put_contents($usersJsonUrl, json_encode($data, JSON_PRETTY_PRINT));
}
?>
