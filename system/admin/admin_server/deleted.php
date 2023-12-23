<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 학번을 POST로 받아옴
    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        // users.json 파일 읽기
        $usersData = file_get_contents('../../../login/users.json');

        // JSON 문자열을 배열로 파싱
        $usersArray = json_decode($usersData, true);

        $userFound = false;

        // 학번을 사용자 정보에서 찾아서 'deleted'로 변경
        foreach ($usersArray as &$user) {
            if ($user['username'] === $username) {
                $user['username'] = 'deleted';
                $userFound = true;
                break;
            }
        }

        if ($userFound) {
            // JSON으로 변환
            $newUsersData = json_encode($usersArray);

            // 파일에 쓰기
            file_put_contents('../../../login/users.json', $newUsersData);

            echo "사용자 정보를 'deleted'로 변경했습니다. 사ㄱ삭제완료";
        } else {
            echo "학번을 찾을 수 없습니다.";
        }
    } else {
        echo "학번을 입력하세요.";
    }
} else {
    echo "잘못된 요청입니다.";
}
?>
