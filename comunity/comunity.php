<?php
session_start();

if (!isset($_SESSION['username'])) {
    // echo "<script>alert('로그인 후 접속 가능합니다.');</script>";
    // echo "<script>window.location.href = 'index.php';</script>";
}

$currentUsername = isset($_SESSION['username']) ? $_SESSION['username'] : null;
$users = json_decode(file_get_contents('../login/users.json'), true);

if (!empty($users)) {
    usort($users, function($a, $b) {
        return $b['point'] - $a['point'];
    });

    $currentUser = null;
    $userRank = null;
    $point = null;

    foreach ($users as $user) {
        if ($user['username'] === $currentUsername) {
            $point = $user['point'];
            $userRank = $user['rank'];
            $currentUser = $user;
            break;
        }
    }

    $isDev = $currentUser !== null && $currentUser['rank'] === 'dev';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $menu = isset($_POST['menu']) ? explode(',', $_POST['menu']) : [];
        file_put_contents('menu.json', json_encode(['menu' => $menu]));
        header("Location: /index.php");
        exit();
    }
}
?>

?>
<?php
function encrypt($plaintext, $key) {
    $method = 'aes-128-cbc';
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);
    return base64_encode($iv.$hmac.$ciphertext_raw);
}

ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];

    if (trim($message) === '') {
        $response = array(
            'status' => 'error',
            'message' => '메시지를 입력해주세요.'
        );
    } else {
        $username = $_SESSION['username'];
        $rank = $_SESSION['rank'];
        $timestamp = date('m-d H:i:s');
        $encryptedUsername = encrypt($username, 'SebXav8GTiQw');
        $blockedMessages = file('no_chat.txt');

        foreach ($blockedMessages as $blockedMessage) {
            $blockedMessage = trim($blockedMessage);
            $message = str_ireplace($blockedMessage, '**', $message);
        }

        $postsData = array();
        if (file_exists('posts.json')) {
            $postsData = json_decode(file_get_contents('posts.json'), true);
        }

        $newPost = array(
            'username' => $encryptedUsername,
            'timestamp' => $timestamp,
            'message' => $message,
            'rank' => $rank
        );

        $postsData[] = $newPost;
        file_put_contents('posts.json', json_encode($postsData, JSON_UNESCAPED_UNICODE));

        $response = array(
            'status' => 'success',
            'message' => '메시지를 전송했습니다.'
        );
    }
}

ob_end_clean();
?>

<?php
$postsData = array();
if (file_exists('posts.json')) {
    $postsData = json_decode(file_get_contents('posts.json'), true);
}
?>
<?php
$date = date('H시 i분');
?>
  <?php
  $users = json_decode(file_get_contents('../login/users.json'), true);
  $totalUsers = count($users); // 전체 인원수

  // 자신의 등수 확인
  $currentUserRank = null;
  $remainingRanks = null;
  if ($currentUsername) {
      foreach ($users as $index => $user) {
          if ($user['username'] === $currentUsername) {
              $currentUserRank = $index + 1; // 0부터 시작하므로 1을 더함
              $remainingRanks = $totalUsers - $currentUserRank; // 남은 등수 계산
              break;
          }
      }
  }

  ?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
    <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>서라벌고 커뮤니티</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="footer.css">
    <script>
    // JSON 파일을 읽고 정렬 후 표를 만드는 함수
    async function loadAndShowRanking(username) {
      try {
        const response = await fetch('../login/users.json');
        const users = await response.json();
        users.sort((a, b) => b.point - a.point);

        const rankingTableBody = document.getElementById('rankingTableBody');
        rankingTableBody.innerHTML = '';
        users.forEach((user, index) => {
          const rank = index + 1;
          const tableRow = `
            <tr${user.username === username ? ' style="background-color: #f2f2f2;"' : ''}>
              <td>${rank}</td>
              <td>${user.username}</td>
              <td>${user.point}</td>
            </tr>
          `;
          rankingTableBody.innerHTML += tableRow;
        });

        // 현재 사용자의 랭킹 정보를 기준으로 스크롤 위치를 인식합니다.
        const currentUserRank = users.findIndex(user => user.username === username) + 1;
        document.querySelector('.ranking-table-wrapper').scrollTop = Math.max((currentUserRank - 3) * 25, 0);
      } catch (error) {
        console.error(error);
      }
    }

    // 1분마다 랭킹 정보를 업데이트합니다.
    function updateRanking(username) {
      loadAndShowRanking(username);
      setTimeout(() => updateRanking(username), 1000 * 60);
    }

    // 초기 로딩 시 랭킹 정보를 표시합니다.
    const username = <?= json_encode($currentUsername)?>;
    loadAndShowRanking(username);

    // 1분마다 랭킹 정보를 업데이트합니다.
    updateRanking(username);
  </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body onload="updateRanking(<?= json_encode($currentUsername)?>)">
  <div class="container">
    <div class="title_M">
      <a href="/index.php">  
        <span style="color: blue;">서</span>
        <span style="color: red;">라</span>
        <span style="color: green;">벌</span>
        <span style="color: orange;">고</span>
        <span style="color: purple;">커</span>
        <span style="color: brown;">뮤</span>
        <span style="color: navy;">니</span>
        <span style="color: pink;">티</span>
      </a>
    </div>
  </div>
  
  
        
            <div class="box">
              <div class="title">
            공지
            <!-- 일반 사용자용 출석체크 버튼 -->
<?php 
if (isset($_SESSION['username'])) { ?>
  <form method="POST" action="checkin.php">
    <input type="hidden" name="checkin" value="true">
    <button type="submit">출석체크</button>
  </form>
<?php } ?>

            </div>
            
        <?php
        // 공지 텍스트가 저장된 notice.json 파일 불러오기
        $noticeJsonPath = 'notice.json';
        $noticeData = file_exists($noticeJsonPath) ? json_decode(file_get_contents($noticeJsonPath), true) : array();
        $noticeText = isset($noticeData['noticeText']) ? $noticeData['noticeText'] : '공지 없음';

        echo '<p class="content">' . nl2br(htmlspecialchars($noticeText)) . '</p>';
        ?>
    </div>
        <!-- 랭킹 정보 -->
  <div class="box">
      <div class="title">
          랭킹 | 보상까지 남은 등수 ,  전체 <?php echo $totalUsers; ?> 등 중/ <?php echo $remainingRanks; ?>등)
          <!-- 일반 사용자용 출석체크 버튼 -->
          <button id="btn-attendance-toggle">오늘의 급식</button>
      </div>

      <!-- 랭킹 정보 표시 -->
      <div class="ranking-table-wrapper">
          <table>
              <thead>
                  <tr>
                      <th>등수</th>  
                      <th>학번</th>
                      <th>포인트</th>
                  </tr>
              </thead>
              <tbody id="rankingTableBody">
                  <?php
                  for ($i = 0; $i < min(5, count($users)); $i++) {
                      $row = $users[$i];
                      $cssClass = $currentUser !== null && $currentUser['rank'] === $row['rank'] ? 'current-user' : '';
                  ?>
                  <tr class="<?= $cssClass ?>">
                      <td><?= $i + 1 ?></td>
                      <td><?= $row['username'] ?></td>
                      <td><?= $row['point'] ?></td>
                  </tr>
                  <?php } ?>
              </tbody>
          </table>
      </div>
  </div>
      <!-- 출석체크 부분 -->
<div class="box" id="attendance">
    <div class="title">오늘의 메뉴(<?= date('m월 d일') ?>)</div>
    <p class="menu"><?= getSchoolMeal($schoolId, $officeCode) ?></p>
</div>

<?php
function getSchoolMeal($schoolId, $officeCode) {
    $apiKey = '45a042fca35c42a4bccad5d7c5c67e04';
    $baseUrl = 'https://open.neis.go.kr/hub/mealServiceDietInfo';

    $today = date('Ymd');
    
    $params = array(
        'KEY' => $apiKey,
        'Type' => 'json',
        'ATPT_OFCDC_SC_CODE' => $officeCode,
        'SD_SCHUL_CODE' => $schoolId,
        'MLSV_YMD' => $today,
    );

    $url = sprintf("%s?%s", $baseUrl, http_build_query($params));

    try {
        $response = file_get_contents($url);

        if ($response !== false) {
            $data = json_decode($response, true);

            try {
                if (isset($data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM'])) {
                    // 급식 정보가 있는 경우
                    return str_replace('<br/>', PHP_EOL, 
                        @$data['mealServiceDietInfo'][1]['row'][0]['DDISH_NM']);
                } else {
                    // 해당 날짜의 급식 정보가 없는 경우
                    return "해당 날짜의 급식 정보가 없습니다.";
                }
            } catch (Exception$e) {
                return "해당 날짜의 급식 정보를 불러오지 못했습니다.";
            }
        } else {
            return "API 요청에 실패했습니다."; // 요청 실패시 재요청하기
        }
    } catch (Exception$e) {
        echo "API 요청 중 오류가 발생했습니다: ",$e->getMessage();
    }
}
?>
      
        <!-- 커뮤니티 글 작성 / 관리 버튼 -->
<div class="box">
<div class="title">익명메세지
    <img src="/img/logo_mg.png" alt="icon" style="height: 30px; width: 30px; margin-right: 5px;">
</div>
  <div id="message-wrapper">
    <!-- 메시지 출력 영역 -->
    <?php foreach ($postsData as $index => $post) : ?>
      <div class="message">
        <p><?php echo $post['message']; ?></p>
      
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($currentUsername) : ?>
    <form id="message-form" method="post" action="send_message.php">
<div class="input-wrapper">
  <input type="text" class="form-control message-input" id="message" name="message" placeholder="메시지 입력">
  <button type="submit" class="btn btn-primary message-send-btn">전송</button>
</div>
    </form>
  <?php else : ?>
    <p>로그인 후에 메시지를 전송할 수 있습니다.</p>
  <?php endif; ?>
</div>   
<div class="box_ds" style="display:none">
  <div class="title">
<span style="color: blue;">N</span>
<span style="color: red;">o</span>
<span style="color: green;">i</span>
<span style="color: purple;">s</span>
<span style="color: orange;">y</span>
<span>&nbsp;</span>
<span style="color: blue;">W</span>
<span style="color: red;">e</span>
<span style="color: green;">b</span>
<span style="color: purple;">b</span>
<span>&nbsp;</span>
<span style="color: orange;">|&nbsp;</span>
<span style="color: blue;">D</span>
<span style="color: red;">e</span>
<span style="color: green;">v</span>
</div>

  <table>
    <tr>
    <tr>
    <td><span style="color: yellow;">Noisy IT Haed of Support</span>
    <td><span"><u>허윤호</u></span></td>
    </tr>
    <tr>
    <td><span style="color: purple;">Webb Service</span> <span style="color: black;">&</span> <span style="color: green;">DB Manager</span></td>
    <td><span"><u>이종우</u></span></td>
    </tr>
    </tr>
    <tr>
  <td><span style="color: blue;">Project Manager</span> <span style="color: black;">&</span> <span style="color: red; text-decoration: underline; text-decoration-color: #F00; text-decoration-style: solid; box-shadow: 0 0 7px #F00;"> Backend Duty</span></td>
    <td><span><u>강하람</u></span></td>
    </tr>
    <tr>
    <td>
<span style="color: orange; text-decoration: underline; text-decoration-color: #FFA500; text-decoration-style: solid; box-shadow: 0 0 7px #FFA500;">Front-Duty</span> <span style="color: black;">&</span> <span style="color: purple; text-decoration: underline; text-decoration-color: #800080;">Graphics Art Duty</span></td>
    <td><u>박민찬</u></td>
    </tr>
    
    </tr>
    <tr>
    <td><span style="color: purple;">Front-end</span> <span style="color: black;">&</span> <span style="color: #FFB2D9;">Document Team</span>
    <td><u>이동준</u></td>
    </tr>
    <tr>
    <td><span style="color: purple;">Front-end</span> <span style="color: black;">&</span> <span style="color: #A6A6A6;">Data Research</span>
    <td><u>김태윤</u></td>
    </tr>
    <tr>
    <td><span style="color: purple;">Front-end</span> <span style="color: black;">&</span> <span style="color: #D4F4FA;">Tosters Team</span>
    <td><u>오명훈</u></td>
    </tr>
  </table>
</div>

  <div class="box">
    <div class="title">구기대회 일정   (<?= date('m월 d일') ?>)</div>
  <div class="section-title-1" style="color: purple;">1학년부 VS</div>
  <div class="divider">
    <div class="section-title-2" style="color: orange;">2학년부 VS</div>
  </div>
  <div class="box">
      <div class="title-an">실시간 (<?php $date = date('H시 i분'); echo $date; ?>)</div>

      <div id="live_data" class="xs" style="text-align: center; font-size: 24px;"></div>
  </div>
  </div>


</div> 
  
<footer>
 <p class="center">
    <span><a href="/game/info.php">클릭!</a>(c) 2023 NoisyIT <u id="dev">Webb Team (웹부) | Developers View!</u></span><br />
  </p>
</footer>
  
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  fetch('1st.json')
    .then(response => response.json())
    .then(data => {
      const first1 = data['1st']['1st_1'];
      const first2 = data['1st']['1st_2'];

      const sectionTitle1 = document.querySelector('.section-title-1');

      const left = document.createElement('div');
      left.textContent = first1;
      left.classList.add('red');
      left.style.float = 'left';

      const right = document.createElement('div');
      right.textContent = first2;
      right.classList.add('blue');
      right.style.float = 'right';

      sectionTitle1.insertAdjacentElement('beforebegin', left);
      sectionTitle1.insertAdjacentElement('beforebegin', right);
  })
  .catch(error => {
    console.log(error);
  })

  fetch('1st.json')
    .then(response => response.json())
    .then(data => {
      const second1 = data['2st']['2st_1'];
      const second2 = data['2st']['2st_2'];

      const sectionTitle2 = document.querySelector('.section-title-2');

      const left = document.createElement('div');
      left.textContent = second1;
      left.classList.add('red');
      left.style.float = 'left';

      const right = document.createElement('div');
      right.textContent = second2;
      right.classList.add('blue');
      right.style.float = 'right';

      sectionTitle2.insertAdjacentElement('beforebegin', left);
      sectionTitle2.insertAdjacentElement('beforebegin', right);
  })
  .catch(error => {
    console.log(error);
  })
  </script>
<script>
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: 'live_core.json',
                dataType: 'json',
                success: function(data) {
                    $('#date').html(data['current_date_time']);
                    $('#live_data').html(data['live_st']['live_1'] + ' vs ' + data['live_st']['live_2']);
                }
            });
        }, 1000);
    });
</script>
<script>
  // "웹부" 텍스트를 클릭했을 때 실행될 함수
  function showBox() {
    // "box_ds" 클래스를 가진 요소를 가져와서 보이게 함
    document.querySelector('.box_ds').style.display = 'block';
  }

  // "웹부" 텍스트 요소를 가져와서 클릭 이벤트를 추가함
  document.querySelector('#dev').addEventListener('click', showBox);
  
  // "문의하기" 텍스트 요소를 가져와서 클릭 이벤트를 추가하고 해당 페이지로 이동함
  document.querySelector('a[href="support.html"]').addEventListener('click', function(e) {
    e.preventDefault(); // a 태그의 기본 클릭 이벤트를 취소
    location.href = 'support.html'; // 페이지 이동
  });
</script>

<script>
    $(document).ready(function() {
        $("#btn-attendance-toggle").on("click", function() {
            $("#ranking").toggle();
            $("#attendance").toggle();
        });

        // 출석체크 닫기 버튼 클릭 시, 출석체크 BOX 사라지도록 설정
        $("#btn-attendance-close").on("click", function() {
            $("#attendance").hide();
        });
    });
</script>
  <script>
  $(document).ready(function() {
    $("#message-form").submit(function(e) {
      e.preventDefault();
      var message = $("#message").val();
      if (message.trim() === '') {
        return;
      }
      $.ajax({
        type: "POST",
        url: "send_message.php",
        data: { message: message },
        dataType: "json",
        success: function(response) {
          var messageClass = response.status === 'success' ? 'text-danger' : 'text-secondary';
          var messageHtml = '<p class="' + messageClass + '">' + response.message + '</p>';
          $('#message-wrapper').append(messageHtml);
          if (response.status === 'success') {
            $("#message").val('');
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
          var messageHtml = '<p class="text-secondary">메세지를 서버에 전송중   입니다.</p>';
          $('#message-wrapper').append(messageHtml);
        }
      });
    });
  });
</script>

  <script>
  $(document).ready(function() {
    // 1초마다 메시지 업데이트 함수 호출 // 5초로 변경 // 개발떈 30초로
    setInterval(updateMessages, 1000);

    function updateMessages() {
      $.ajax({
        type: "GET",
        url: "posts.json",
        dataType: "json",
        success: function(response) {
          // 메시지 출력 영역 초기화
          $("#message-wrapper").empty();

          // 새로운 메시지 추가
          response.forEach(function(post) {
            var messageHtml = '<p>' + post.message + '</p>';
            $('#message-wrapper').append(messageHtml);
          });
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
  });
</script>
<script>
  var button = document.getElementById("btn-index_gogo");  // 버튼 요소 가져오기
  button.onclick = function() {
      window.location.href = "index.php";  // 페이지 이동하기
  }
  function HomeBtn() {
      window.location.href = 've_index.php';
  }
</script>
</body>
</html>


