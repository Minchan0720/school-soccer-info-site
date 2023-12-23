<?php
setcookie("noisy_web_pass", "본 쿠키는 정보를 수집 혹은 저장하지 않습니다", time() + 3600);
?>
<!DOCTYPE html>
<html>
<head>
  <title>| Noisy IT</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="서라벌 고등학교 대표 동아리 Noisy IT가 제공하는 웹 프로젝트">
  <meta name="keywords" content="서라벌고등학교, NoisyIT">
  <meta name="author" content="Noisy_IT_웹조">
  <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
  <meta http-equiv="refresh" content="1.5;url=ve_index.php">
  <!-- /verify/anti_user.php 로 수정 하기 -->
  <style>
    * {
      border: 0;
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      background: black; /* 항상 검은색 배경 */
      color: white; /* 흰색 글자 */
      font: 1em/1.5 sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .pl {
      display: block;
      width: 6.25em;
      height: 6.25em;
    }
    .pl__ring, .pl__ball {
      animation: ring 2s ease-out infinite;
    }
    .pl__ball {
      animation-name: ball;
    }
    /* Animation */
    @keyframes ring {
      from {
        stroke-dasharray: 0 257 0 0 1 0 0 258;
      }
      25% {
        stroke-dasharray: 0 0 0 0 257 0 258 0;
      }
      50%, to {
        stroke-dasharray: 0 0 0 0 0 515 0 0;
      }
    }
    @keyframes ball {
      from, 50% {
        animation-timing-function: ease-in;
        stroke-dashoffset: 1;
      }
      64% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -109;
      }
      78% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -145;
      }
      92% {
        animation-timing-function: ease-in;
        stroke-dashoffset: -157;
      }
      57%, 71%, 85%, 99%, to {
        animation-timing-function: ease-out;
        stroke-dashoffset: -163;
      }
    }
  </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,700&display=swap">
  <style>
  .logo {
    display: block;
    margin-left: auto;
    margin-right: auto; 
    margin-top: 25vh;
    height: auto;
   }
  </style>
</head>
<body>
  <svg class="pl" viewBox="0 0 200 200" width="200" height="200" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="pl-grad1" x1="1" y1="0.5" x2="0" y2="0.5">
        <stop offset="0%" stop-color="hsl(313,90%,55%)" />
        <stop offset="100%" stop-color="hsl(223,90%,55%)" />
      </linearGradient>
      <linearGradient id="pl-grad2" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="hsl(313,90%,55%)" />
        <stop offset="100%" stop-color="hsl(223,90%,55%)" />
      </linearGradient>
    </defs>
    <circle class="pl__ring" cx="100" cy="100" r="82" fill="none" stroke="url(#pl-grad1)" stroke-width="36" stroke-dasharray="0 257 1 257" stroke-dashoffset="0.01" stroke-linecap="round" transform="rotate(-90,100,100)" />
    <line class="pl__ball" stroke="url(#pl-grad2)" x1="100" y1="18" x2="100.01" y2="182" stroke-width="36" stroke-dasharray="1 165" stroke-linecap="round" />
  </svg>
  <body>
<img src="img/Noisy2023.png" alt="logo" class="logo" style="width: 200px;">
</body>
</html>