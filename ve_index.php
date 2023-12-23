<?php 
    // php 모든 시스템은 '/system/php/파일값.php 에 넣어놈 이건 ve_index
    include_once($_SERVER['DOCUMENT_ROOT'] . '/system/php/ve_index_php.php');
?>
<?php
if (!isset($_COOKIE['noisy_web_pass'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <!-- head - meta -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=chrome">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">  
    <!-- head - link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/main.css">  
  <link rel="stylesheet" href="/css/footer.css">  
  <!-- head - title -->    
  <title>| Noisy IT</title>
</head>
  
<body>

  <!-- layout(1) -->

  <top>
    <div class="title">
      <div class="titleM">
        <span class="ac">S</span>orabol <span class="ac">C</span>hampions <span class="ac">L</span>eague 승부예측 이벤트
      </div>
    </div>
      <?php if ($user_rank === 'dev'): ?>
        <div id="dev" onclick="HomeBtn()"></div>
      <?php else: ?>
        <div id="NoisyItLogo" onclick="HomeBtn()"> <b>HOME</b> </div>
      <?php endif; ?>
  </top>
  
<footer>
  <nav class="center">
    <a href='https://drive.google.com/file/d/117nJPBQ3u1flR7c8KsQ_PEse6wT1EBW0/view' target='_blank'>이용약관</a> |
    <a href='game/info.php' target='_blank' >"만든사람들!"</a> |
    <a href='https://drive.google.com/file/d/117nJPBQ3u1flR7c8KsQ_PEse6wT1EBW0/view' target='_blank'>개인정보</a>
  </nav>
    <p class="center">
        <span>2023 Web Performance | NT</span><br/>
        <span>Mail : support@sorabol.co.kr (메일)</span><br/>
        <span>Copyright 2023.Noisy.it All Rights Reserved.</span>
    <br/>
<?php
if (isset($user_username)) {
    echo "<span>{$user_username}님 </span>
          <span><a href='/login/logout.php' style='text-decoration: underline;'>로그아웃</a><a href='/login/reset.php' style='text-decoration: underline;'>오류해결</a></span>";
} else {
    echo "<span>로그인이 필요합니다.</span>
          <span><a href='/login/login_view.php' style='text-decoration: underline;'>로그인</a></span>";
}
?>


</span>
    </p>
</footer>

  
<login>
    <div class="login" id="<?php echo (isset($_SESSION['username']) && !empty($_SESSION['username'])) ? 'login' : 'no_'; ?>"></div>
    <div class="login" id="<?php echo (isset($_SESSION['username']) && !empty($_SESSION['username'])) ? 'profile' : 'no_profile'; ?>"></div>
    <div class="login" id="<?php echo (isset($_SESSION['username']) && !empty($_SESSION['username'])) ? 'profileN' : 'no_profileN'; ?>">
        <span id="profileNText">
            <?php
                if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                    echo htmlspecialchars($_SESSION['username']);  
                } else {
                    echo '<a href="/login/login_view.php" style="color: black; text-decoration: none;">로그인</a>';
                }
            ?>
        </span>
    </div>  
    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
        <div class="login" id="profileP">
            <!-- 3초 마다 가져옴-->
            <span id="profilePText">
                <?php
                    echo isset($points) ? htmlspecialchars($points) . "p" : "0p";
                ?>
            </span>
        </div>
    <?php endif; ?>
</login>
  
  <!-- layout(2) -->
  <div class="layout" id="triangle"></div>
  <div class="layout" id="lec1"></div>
  <div class="layout" id="lec1-notice"></div>
  <div class="layout" id="lec2"></div>

  <div class="layout" id="info">
      <span style="text-decoration: underline; color: gray; cursor: pointer;" onclick="loadSiteInfo2()">보상 |</span>
      <span style="text-decoration: underline; color: gray; cursor: pointer;" onclick="loadSiteInfo()"> 사용법 더보기</span>
      <br>
      2023년도! 서라벌 고등학교 구기대회를 기반으로한 이벤트 입니다!
      <br>
  </div>

  <div class="layout button" id="myinfo" onclick="clmu()">서라벌 커뮤니티</div>
  <div class="layout button" id="myvote" onclick="mine()">나의 정보</div>
  
  <!-- 경기 결과(팀,점수) -->

  <a href="/img/dating.jpg">
      <div class="play1" id="play1"><!--경기결과2--></div>
  </a>
  <div class="play1" id="team1-a"><!--팀A--></div>
  <div class="play1" id="team1-b"><!--팀B--></div>
  <div class="play1" id="score1-1"><!--점수1--></div>
  <div class="play1" id="score1-2"><!--점수2--></div>
  <div class="play1" id="dash1"><b>-</b></div>
  
  
  <a href="/img/dating.jpg">
      <div class="play2" id="play2"><!--경기결과2--></div>
  </a>
  <div class="play2" id="team2-a"><!--팀A--></div>
  <div class="play2" id="team2-b"<!--팀B--></div>
  <div class="play2" id="score2-1"><!--점수1--></div>
  <div class="play2" id="score2-2"><!--점수2--></div>
  <div class="play2" id="dash2"><b>-</b></div>
  
  <!-- layout(3) -->
  <div class="button" id="firstGrade" onclick="openGrade()"><b>학년별<br>축구 승리 베팅</b></div>
  <div class="button" id="secondGrade" onclick="games()"">
      <b>롤링 | </b><b style="color: pink;">Event</b><br>게임 승리 베팅
  </div>

  <!-- <div class="button" id="gift" onclick="openGift()"><b>이용방법</b></div> -->
  

  <!-- javascript -->
  <!-- 스크립트는 scr/에 있음 -->
  <script src="scr/touch_veindex.js"></script>
    <script src="scr/f12.js"></script>
    <?php
    $is_logged_in = isset($_SESSION['username']) && !empty($_SESSION['username']);
    ?>
<script>
<?php
if ($is_logged_in) {
    $username = $_SESSION['username']; // 세션
    echo "let username = '$username';";
} else {
    echo "let username = '';";
}
?>

function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

function setCookie(name, value, days) {
    let expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}
</script>
<script>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
        var username = '<?php echo $_SESSION['username']; ?>';
        console.log("로그인 된 유저:", username);
    <?php else: ?>
        console.log("비 로그인 유저");
    <?php endif; ?>
</script>
  <script>
    document.addEventListener("keydown", function(event) {
      if (event.keyCode === 116) {
        event.preventDefault(); // 기본 동작
        window.location.href = "index.php"; // 개발용 pc 접속시 f5 누르면 index
      }
    });
  </script>
  <script>
  (function(){var w=window;if(w.ChannelIO){return w.console.error("ChannelIO script included twice.");}var ch=function(){ch.c(arguments);};ch.q=[];ch.c=function(args){ch.q.push(args);};w.ChannelIO=ch;function l(){if(w.ChannelIOInitialized){return;}w.ChannelIOInitialized=true;var s=document.createElement("script");s.type="text/javascript";s.async=true;s.src="https://cdn.channel.io/plugin/ch-plugin-web.js";var x=document.getElementsByTagName("script")[0];if(x.parentNode){x.parentNode.insertBefore(s,x);}}if(document.readyState==="complete"){l();}else{w.addEventListener("DOMContentLoaded",l);w.addEventListener("load",l);}})();

  ChannelIO('boot', {
    "pluginKey": "fe083f52-32fc-4342-b7e9-6c09df18d480"
  });
</script>
  <script src="/scr/get_point.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
  crossorigin="sexy"></script>
  <script>
      function loadSiteInfo() {
          // site_info.html
          var xhr = new XMLHttpRequest();
          xhr.open("GET", "site_info.html", true);
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  var siteInfoContent = xhr.responseText;
                  var element = document.getElementById("info");
                  element.innerHTML = siteInfoContent;
              }
          };
          xhr.send();
      }
  </script>
  <script>
      function loadSiteInfo2() {
          // site_info.html
          var xhr = new XMLHttpRequest();
          xhr.open("GET", "site_info2.html", true);
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  var siteInfoContent = xhr.responseText;
                  var element = document.getElementById("info");
                  element.innerHTML = siteInfoContent;
              }
          };
          xhr.send();
      }
  </script>
</body>

</html>