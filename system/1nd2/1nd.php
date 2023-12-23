<?php
// 세션 시작
session_start();

// username 값을 세션에서 가져오기
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "미가입자";
}

// JSON 파일 로드 및 디코딩
$string = file_get_contents("../../login/users.json");
$json_a = json_decode($string, true);

$point = "0"; // 초기값 설정

foreach ($json_a as $user) { // 모든 유저를 순회하며 
    if ($user['username'] == $username) { // username이 일치하는 유저를 찾으면 
        $point = $user['point']; // 그 유저의 point 값 저장 
        break;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // 사용자가 팀을 선택한 경우
   if (isset($_POST["team"]) && isset($_POST["betAmount"])) {
       $selectedTeam = $_POST["team"];
       $betAmount = $_POST["betAmount"];

       if ($selectedTeam == "A") {
           // A팀 데이터 저장하기
           $data_a = array(
               'username' => $username,
               'team' => 'A',
               'betAmount' => intval($betAmount)
           );

           file_put_contents('a_data.json', json_encode($data_a));
       } elseif ($selectedTeam == "B") {
           // B팀 데이터 저장하기
           $data_b = array(
               'username' => $username,
               'team' => 'B',
               'betAmount' => intval($betAmount)
           );

           file_put_contents('b_data.json', json_encode($data_b));
       }
   }
}
?>
<?php

// JSON 파일 로드 및 디코딩
$string = file_get_contents("today_team.json");
$json_a = json_decode($string, true);

$first_team_1 = $json_a['1st']['1st_1'];
$first_team_2 = $json_a['1st']['1st_2'];

?>

<?php
// score.json 파일 읽기
$jsonData = file_get_contents('score.json');

// JSON 데이터를 PHP 배열로 변환
$data = json_decode($jsonData, true);

if (isset($data['1st']['1st_1_score'])) {
    $first_score_1 = $data['1st']['1st_1_score'];
} else {
    $first_score_1 = "값이 없음";
}

if (isset($data['1st']['1st_2_score'])) {
    $team_members = $data['1st']['1st_2_score'];
} else {
    $team_members = "값이 없음";
}

?>

<?php
// score.json 파일 읽기
$jsonData = file_get_contents('score.json');

// JSON 데이터를 PHP 배열로 변환
$data = json_decode($jsonData, true);

if (isset($data['2st']['2st_1'])) {
    $first_score_2 = $data['2st']['2st_1'];
} else {
    $first_score_2 = "값이 없음";
}

if (isset($data['2st']['2st_2'])) {
    $team_members2 = $data['2st']['2st_2'];
} else {
    $team_members2 = "값이 없음";
}

?>
<?php
// 사용자가 팀을 선택한 경우
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["team"]) && isset($_POST["betAmount"])) {
    $selectedTeam = $_POST["team"];
    $betAmount = $_POST["betAmount"];

    if ($selectedTeam == "A") {
        // A팀 데이터 저장하기
        $data_a = array(
            'username' => $username,
            'team' => 'A',
            'betAmount' => intval($betAmount)
        );

        file_put_contents('a_data.json', json_encode($data_a));
    } elseif ($selectedTeam == "B") {
        // B팀 데이터 저장하기
        $data_b = array(
            'username' => $username,
            'team' => 'B',
            'betAmount' => intval($betAmount)
        );

        file_put_contents('b_data.json', json_encode($data_b));
    }
}
?>

  <?php
  // a_data.json 파일 로드
  $data = json_decode(file_get_contents('a_data.json'), true);

  // 중복을 제외한 유니크한 사용자 수 계산
  $uniqueUsers = [];
  foreach ($data as $item) {
      if (is_array($item)) {
          $uniqueUsers[$item['username']] = true;
      }
  }
  $userCount = count($uniqueUsers);
  ?>
  <?php
  // a_data.json 파일 로드
  $data = json_decode(file_get_contents('b_data.json'), true);

  // 중복을 제외한 유니크한 사용자 수 계산
  $uniqueUsers = [];
  foreach ($data as $item) {
      if (is_array($item)) {
          $uniqueUsers[$item['username']] = true;
      }
  }
  $userCount2 = count($uniqueUsers);
  ?>

<!DOCTYPE html>
<html>
<head>
 <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"> <!-- Viewport 수정 -->
    <title>1학년부 베팅</title>
  <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="vote.js"></script>
</head>
<body>
<link href="index.css" rel="stylesheet" />
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // 사용자가 팀을 선택한 경우
   if (isset($_POST["team"])) {
       $selectedTeam = $_POST["team"];
       // echo "<p>선택된 팀은 $selectedTeam 입니다.</p>"; 삭제됨.
   }
}
?>

<form method="post" action="save_data.php"> <!-- 폼 액션 변경 -->
<h1 id="title-text" style="text-align:left;">Noisy IT Webb23</h1> <!-- 제목 박스 -->
  <div class="team-box" data-team="A">
      <h2 class="title"><?php echo $first_team_1; ?></h2> <!-- JSON 데이터 사용 -->
      <p class="subtitle">실시간 투표수 | <?php echo $userCount; ?>개</p>
      <?php echo '<p class="subtitle">주장 | ' . $first_score_1 . '</p>'; ?>
      <a href="#" id="more-link" class="more-link">/ 모든 선수 보기</a>
  </div>

  <div class="team-box" data-team="B">
      <h2 class="title"><?php echo $first_team_2; ?></h2> <!-- JSON 데이터 사용 -->
      <p class="subtitle">실시간 투표수 | <?php echo $userCount2; ?>개</p>
      <?php echo '<p class="subtitle">주장 | ' . $first_score_2 . '</p>'; ?>
      <a href="#" id="more-link" class="more-link">/ 모든 선수 보기</a>
  </div>

<input type="hidden" id="team" name="team">

<br> <!-- <br><br> 에서 <br>로 변경하여 공간을 줄임 -->
<?php if (isset($_SESSION["username"])) { ?>
    <input type='number' id="betAmount" name="betAmount" placeholder='베팅금액을 입력해주세요!' oninput="checkBetAmount()" style="<?php echo ($betAmount > $point) ? 'color: red;' : ''; ?>">

    <div style="text-align: center;">
        <p class='small-text'>
            <span style="color: #1ECD97;"><?php echo "$username 님 $point P 보유중"; ?></span>
        </p>
    </div>

    <button type='submit' id="submitButton" disabled>선택완료</button>
<?php } else { ?>
    <div style="text-align: center;">
        <p class='small-text'>
            <span style="color: #1ECD97;"><?php echo "$username 님 - "; ?></span>
            <a href='/../../login/signup_view.php' style='text-decoration-line: underline; color: #1ECD97;'>회원가입</a>
        </p>
    </div>
<?php } ?>



</form>
<script>
function checkBetAmount() {
    var betAmount = parseInt(document.getElementById("betAmount").value);
    var point = <?php echo $point; ?>;
    var submitButton = document.getElementById("submitButton");

    if (isNaN(betAmount)) {
        submitButton.disabled = true;
        return;
    }

    if (betAmount > point) {
        submitButton.disabled = true;
        document.getElementById("betAmount").style.color = "red";
        submitButton.style.backgroundColor= "red"; // 이 부분 추가
        submitButton.style.borderColor= "red"; // 이 부분 추가
    } else {
        submitButton.disabled = false;
        document.getElementById("betAmount").style.color = "";
        submitButton.style.backgroundColor= "#fff"; // 이 부분 추가
        submitButton.style.borderColor= "#1ECD97"; // 이 부분 추가
    }
}

</script>
<script>
    $(document).ready(function() {
       $(".team-box").click(function() {
           $(".team-box").removeClass("selected");
           $(this).addClass("selected");
           $("#team").val($(this).attr('data-team'));
       updateButtonText(); //버튼 텍스트 업데이트
       });

     $("input[type='number']").change(function() { //숫자 입력 시 버튼 텍스트 업데이트
       updateButtonText();
     });

     function updateButtonText() { //버튼 텍스트 업데이트 함수
       var team = $("#team").val();
       var amount = $("input[type='number']").val();
           if (team && amount) {
         $("button").text(team + " 팀 선택하기 | 금액 : " + amount);
               $('button').prop('disabled', false);  /* 버튼 활성화 */
               window.scrollTo(0,document.body.scrollHeight); /* 페이지 아래로 스크롤 */
           } else {
               $('button').prop('disabled', true);   /* 버튼 비활성화 */
           }
     }
   });
</script>
</body>
</html>
