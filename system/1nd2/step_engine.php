<?php
session_start();

// 세션에서 username 가져오기
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

if ($username === null) {
    echo "<script>
      alert('로그인 하십시오');
      location.href = '/login/login_view.php';
    </script>";
} else {
    // username 첫번째 글자와 4번째 글자 추출
    $firstChar = substr($username, 0, 1);
    $fourthChar = substr($username, 3, 1);

    // 첫번째 글자 또는 4번째 글자에 따른 분기 처리
    if($firstChar == '4' || $fourthChar >= '4'){
        $data = file_get_contents('../../login/users.json');
        $users = json_decode($data, true);

        foreach ($users as $key => $user) {
            if ($user['username'] == $username) {
                $users[$key]['username'] = 'deleted user';
                $users[$key]['name'] = 'deleted user';
                $users[$key]['password'] = 'deleted user';
                $users[$key]['phone'] = 'deleted user';
                $users[$key]['point'] = 0;
                $users[$key]['value'] = 0;
                $users[$key]['value2'] = 0;
                $users[$key]['rank'] = 'deleted user';
                break;
            }
        }

        file_put_contents('../../login/users.json', json_encode($users));

        echo "<script>
          alert('계정이 정지되었습니다.');
            history.go(-1);
            setTimeout(function() {
                alert('계정이 정지되었습니다.');
                location.href = '/login/login_view.php';
            }, 1000);
        </script>";
        // 모든 세션 삭제
        session_destroy();
    } else {
        switch($firstChar){
            case '1':
                header('Location: /system/1nd2/1nd.php');
                break;
            case '2':
                header('Location: /system/1nd2/2nd.php');
                break;
            case '3':
                echo "<script>
                    alert('3학년은 참가 불가 합니다');
                    history.go(-1);
                </script>";
                break;
        }
    }
}
?>
<?php
setcookie("veting_manager", "본 쿠키는 정보를 수집 혹은 저장하지 않습니다", time() + 3600);
?>
