<?php
$logfile = 'no_key_time_log.json';

date_default_timezone_set("Asia/Seoul");
$now = time();

file_put_contents($logfile, json_encode([$now]));

$last_visit = json_decode(file_get_contents($logfile))[0];
$last_visit_time = date("Y-m-d H:i:s", $last_visit);
?>
<?php
session_start();

if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: anti_admin.php');
    exit;
}
?>
<?php
function decrypt_log($encrypted_data, $key) {
    $encryption_key = base64_decode($key);
    $data = base64_decode($encrypted_data);
    list($encrypted_data, $iv) = array(substr($data, 0, -16), substr($data, -16));
    $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    if ($decrypted_data === false) {
        return null;
    }

    return $decrypted_data;
}


function get_online_users_count() {
    $logs = file_exists('anti_admin_user.json') ? json_decode(file_get_contents('anti_admin_user.json'), true) : [];

    $online_users_count = 0;
    $decryption_key = '1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    foreach ($logs as $log) {
        $decrypted_log_data = decrypt_log($log['log'], $decryption_key);
        if ($decrypted_log_data !== null) {
            try {
                $decrypted_log = json_decode($decrypted_log_data, true, flags: JSON_THROW_ON_ERROR);
                if (time() - $decrypted_log['access_time'] < 300) {
                    $online_users_count++;
                }
            } catch (JsonException $e) {
            }
        }
    }

    return $online_users_count;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title> | 지원센터 관리자</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Noisy IT 지원센터 관리자 패널">
    <meta name="author" content="anonymoney~~">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gaesegi&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
</head>
<body>
    <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f5f5f5;
    }
    .container {
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    .box {
      flex-basis: 100%; /* 박스 가로 사이즈 */
      min-height: 200px; /* 세로 크기 키우기 */
      background-color: #d9d9d9;
      padding: 20px;
      margin-bottom: 10px;
      display: flex;
      justify-content: center;
      align-items: center; /* 가로 세로 중앙으로 배치 */
    }
    .box h2 {
      margin: 0;
    }
    .secured-containerd {
    display: flex;
    flex-direction: column;
    align-items: center;
    }
    .title {
      margin-top: -100px;
    }
  </style>
</head>
<body>
<div class="logout-container">
  <form method="post" action="logout.php">
    <button type="submit">로그아웃</button>
    <button class="button" onclick="extendTime()">연장하기</button>
    <span class="timer"></span>
    <span>Noisy IT 웹조 지원센터 관리자</span>
  </form>
  <button id="toggle-dark-mode-btn" type="button" onclick="window.location.href = '/admin_json_manager.php';">json manager</button>
  <p class="message">IP: <?php echo $_SERVER['REMOTE_ADDR']; ?> | 접속 : <?php echo $last_visit_time; ?></p>
</div>


  
    <div class="container">
<div class="box">
  <?php include 'include_php/satify.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/admin_signup.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/admin_deleted.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/admin_pointup.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/all_users.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/team_up.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/admin_1nd.php'; ?>
</div>
<div class="box">
  <?php include 'include_php/admin_2nd.php'; ?>
</div>
        <script>
  (function() {
    // 로그인 시각을 가져옵니다.
    var lastVisit = new Date("<?php echo $last_visit_time; ?>").getTime();
    // 타이머를 시작합니다.
    var timer = setInterval(updateTimer, 1000);

    // 남은 시간을 갱신하는 함수입니다.
    function updateTimer() {
      // 지금 시각과 마지막 접속 시각의 차이를 계산합니다.
      var now = new Date().getTime();
      var timeLeft = (lastVisit + (5 * 60 * 1000)) - now;
      // 타이머에 남은 시간을 출력합니다.
      var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
      document.querySelector('.timer').innerHTML = minutes + "분 " + seconds + "초 남음";
      
      // 남은 시간이 0이 되면 자동으로 로그아웃됩니다.
      if (timeLeft < 0) {
        clearInterval(timer);
        triggerLogout();
      }
    }
  })();
</script>
  <script>
  // 타이머를 갱신합니다.
  function updateTimer() {
    // ...
  }

  function triggerLogout() {
    alert("보안경고 | 새로고침시 데이터 유실 될수 있음");
    location.reload();
  }
  function extendTime() {
    localStorage.setItem('lastVisit', new Date().getTime());
  }

  window.onload = function() {
    var lastVisit = localStorage.getItem('lastVisit') || "<?php echo $last_visit; ?>";
    var timer = setInterval(updateTimer, 1000);
    updateTimer();
    window.addEventListener("beforeunload", function(event) {
      triggerLogout();
    });
  }
</script>  

   <script>
        function searchPoints() {
            var username = document.getElementById("username").value;
            if (username === "") {
                alert("학번을 입력해주세요.");
                return;
            }
            
            fetch("pointsearch.php", { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                body: 'username=' + encodeURIComponent(username) 
            })
            .then(response => response.text())
            .then(points => {
                if (points === "") {
                    alert('잘못된 학번입니다.');
                } else {
                    document.getElementById("current_points").innerHTML = points;
                }
            });
        }
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>