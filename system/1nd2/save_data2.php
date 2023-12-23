<?php
session_start();
$timeData = json_decode(file_get_contents("time.json"), true);

// 투표 가능 여부 확인
if ($timeData["voting"] === "no") {
    echo "<script>alert('지금은 투표 시간이 아닙니다.'); window.location.href = '/index.php';</script>";
    exit;
}
?>
<?php
if (!isset($_COOKIE['veting_manager'])) {
    header("Location: /index.php");
    exit;
}
?>
<?php
  // a_data.json 파일 로드 및 디코딩
  $aData = json_decode(file_get_contents('a_2_data.json'), true);

  // username을 통해 이미 투표한 데이터 확인
  if (isset($aData['username']) && $aData['username'] === $_SESSION["username"]) {
      echo "<script>alert('이미 투표하셨습니다.'); window.location.href = '/index.php';</script>";
      exit;
  }

  foreach ($aData as $key => $data) {
      if (is_array($data) && $data['username'] === $_SESSION["username"]) {
          echo "<script>alert('이미 투표하셨습니다.'); window.location.href = '/index.php';</script>";
          exit;
      }
  }

  ?>
<?php
// 사용자가 팀을 선택한 경우
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["team"]) && isset($_POST["betAmount"])) {
    $selectedTeam = $_POST["team"];
    $betAmount = intval($_POST["betAmount"]);

    if ($selectedTeam == "A") {
        // A팀 데이터 저장하기
        $data_a = array(
            'username' => $_SESSION["username"],
            'team' => 'A',
            'betAmount' => $betAmount
        );

        // 기존 데이터 로드
        $existingData = json_decode(file_get_contents('a_2_data.json'), true);
        if ($existingData === null) {
            $existingData = [];
        }

        // 데이터 추가
        $existingData[] = $data_a;

        // 데이터 저장
        file_put_contents('a_2_data.json', json_encode($existingData));
    } elseif ($selectedTeam == "B") {
        // B팀 데이터 저장하기
        $data_b = array(
            'username' => $_SESSION["username"],
            'team' => 'B',
            'betAmount' => $betAmount
        );

        // 기존 데이터 로드
        $existingData = json_decode(file_get_contents('b_2_data.json'), true);
        if ($existingData === null) {
            $existingData = [];
        }

        // 데이터 추가
        $existingData[] = $data_b;

        // 데이터 저장
        file_put_contents('b_2_data.json', json_encode($existingData));
    }

    // users.json 파일 로드 및 디코딩
    $usersData = json_decode(file_get_contents("../../login/users.json"), true);

    // 사용자의 포인트 차감
    foreach ($usersData as &$user) {
        if ($user['username'] === $_SESSION["username"]) {
            $user['point'] -= $betAmount;
        }
    }

    // 변경된 사용자 데이터를 다시 인코딩하여 파일에 저장
    file_put_contents("../../login/users.json", json_encode($usersData));
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>선택 완료</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="2;url=/index.php">
  <style>
    #progress-bar {
      width: 100%;
      height: 10px;
      background-color: #f1f1f1;
      position: fixed;
      top: 0;
      left: 0;
    }

    #progress-bar-inner {
      height: 100%;
      background-color: #1ECD97;
      width: 0%;
    }

    body {
        display:flex;
        flex-direction :column;
        align-items:center;
        justify-content:center;
        height :100vh; 
     }

     h1 {
         text-align:center; 
         margin-top :20px; 
     }

     .button {
         display:inline-block; 
         padding :10px 20px; 
         background-color:#1ECD97; 
         color:white; 
         border-radius :50px;  
         text-decoration:none; 
         font-size :16px ;  
     }

     .button:hover{
          opacity :0.8 ;  
     }

     .button:focus{
          outline:none ;  
     }

     .button-container{
          margin-top :20px;;  
       }
   </style>
</head>
<body>

<div id="progress-bar">
   <div id="progress-bar-inner"></div>
</div>

<h1>베팅 완료</h1>

<div class="button-container">
   <a href="/index.php" class="button">메인페이지로 이동하기</a>
</div>

<script type="text/javascript">
function updateProgressBar() {
   var progressBar = document.getElementById('progress-bar-inner');
   var progress = setInterval(frame,30);
   var width = 0;

   function frame() {
       if (width >=100) {
           clearInterval(progress);
       } else {
           width++;
           progressBar.style.width = width + '%';
       }
   }
}

setTimeout(updateProgressBar,500);
</script>

</body>
</html>
