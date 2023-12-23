<?php if (isset($_GET['error']) && $_GET['error'] == 'username_taken'): ?>
<p style="color: red; font-size: small;">이미 가입된 학번 입니다.</p>
<?php endif; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>| 회원가입</title>
  <link rel="icon" href="img/noisyit.png" type="image/x-icon"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Gaesegi&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
        }
        .form-container {
            max-width: 480px;
            margin: 40px auto;
        }
        .form-group {
            margin: 20px 0;
        }
        .form-control, .btn {
            font-size: 18px;
            padding: 12px 20px;
            border-radius: 25px;
        }
        .form-check {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .title {
            font-family: 'Gaesegi', cursive;
            font-size: 40px;
        }
    </style>
      <script>
        function validateAndFormatPhoneNumber() {
            var inputPhone = document.getElementById('phone');
            inputPhone.value = inputPhone.value.replace(/[^0-9]/g, '');

            if (inputPhone.value.length > 11){
                inputPhone.value = inputPhone.value.substring(0, 11);
            }
        }

        function validateAndFormatStudentId() {
            var inputStudentId = document.getElementById('username');
            inputStudentId.value = inputStudentId.value.replace(/[^0-9]/g, '');

            if (inputStudentId.value.length > 5) {
                inputStudentId.value = inputStudentId.value.substring(0, 5);
            }
        }

        function validateAndFormatPassword() {
            var inputPassword = document.getElementById('password');
            inputPassword.value = inputPassword.value.replace(/[^0-9]/g, '');

            if (inputPassword.value.length > 4) {
                inputPassword.value = inputPassword.value.substring(0, 4);
            }
        }
    </script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <h1 class="title h3 mb-3 fw-normal text-center">Noisy IT 회원가입</h1>
            <form action="signup.php" method="post">

              
<div class="form-group">
    <input type="text" id="username" name="username" class="form-control" placeholder="학번 | 예 21101" title="학번이 정확하지 않을시 계정이 삭제될수 있습니다." pattern="[0-9]{5}" required style="
        background-image: url('/img/profile-icon.png');
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 20px 20px;  
        padding-left: 40px;
    ">
</div>
<div class="form-group">
    <input type="text" id="name" name="name" class="form-control" placeholder="이름 | 별명" required style="
        background-image: url('/img/im_icon.png');
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 20px 20px;  
        padding-left: 40px;
    ">
</div>
<div class="form-group">
    <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호 | 숫자 4자리" title="개인정보 처리방침에 의해 안전하게 보관 됩니다." pattern="[0-9]{4}" required style="
        background-image: url('/img/pss-icon.png');
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 20px 20px;  
        padding-left: 40px;
    ">
        <img src="/img/password-view.png" alt="" id="togglePassword" style="
          position:absolute;
          right:10px;
          height:20px;
      " onclick="
        var passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
      ">
  </div>
<div class="form-group">
    <input type="tel" id="phone" name="phone" class="form-control" placeholder="전화번호 | - 을 빼고 입력하세요" title="전화번호는 서비스 이용방침에 따라 사용될수 있습니다." pattern="[0-9]+" required style="
        background-image: url('/img/phone_icon.png');
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 20px 20px;  
        padding-left: 40px;
    ">
</div>

                  
                <div class="form-group text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="agree" name="agree" required>
                        <label class="form-check-label" for="agree">
                            <a href="/view/law/개인정보.html" target="_blank" style="color: black">개인정보 처리방침</a> 및
                            <a href="https://drive.google.com/file/d/117nJPBQ3u1flR7c8KsQ_PEse6wT1EBW0/view" target="_blank" style="color: black">서비스 이용방침</a> 동의
                        </label>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <img src="/img/galo_wh.png" alt="로고" style="max-width: 50%; height: auto;">
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit" style="background-color: #666;">회원가입</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const nameError = urlParams.get('error');
    
            if (nameError === 'name_restricted') {
                alert('금지된 아이디입니다.');
                // 경고창이 닫힌 후144444 리디렉션
                window.location.href = '/login/signup_view.php';
            }
        };
    </script>
</body>

</html>
