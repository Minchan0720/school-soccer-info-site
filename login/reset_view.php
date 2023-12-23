<?php
if (!isset($_COOKIE['noisy_web_pass'])) {
    header("Location: /index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>비밀번호 찾기</title>
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
        .title {
            font-family: 'Gaesegi', cursive;
            font-size: 40px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function sendData() {
            var studentID = $("#studentID").val();
            var phoneNumber = $("#phoneNumber").val();
            var name = $("#name").val();
            var webhookURL = "https://discord.com/api/webhooks/1132254322114179085/LWSkTFeLSVIOipWuOiFhxTV1JxOyXDrheVYA6sBJXus2tDUPxt_tIei7-LAotpqXRUVy";
            
            var data = {
                "content": "문의 접수",
                "embeds": [{
                    "title": "비밀번호 찾기 요청",
                    "fields": [
                        { "name": "학번", "value": studentID, "inline": true },
                        { "name": "전화번호", "value": phoneNumber, "inline": true },
                        { "name": "이름", "value": name, "inline": true }
                    ],
                    "color": 5814783
                }]
            };

            $.ajax({
                type: "POST",
                url: webhookURL,
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function() { 
                    alert("빠른 시일 내 지원팀이 연락 드리겠습니다."); 
                    window.location.href = "/ve_index.php";
                },
                failure: function(errMsg) { 
                    alert("비밀번호 찾기 요청에 실패했습니다. 카카오톡 지원센터를 통해 요청해주세요."); 
                }
            });
        }
    </script>
</head>

<body class="bg-light">
    <div class="container">
        <div class="form-container">
            <h1 class="title h3 mb-3 fw-normal text-center">비밀번호 찾기</h1>
            <form id="resetForm">
                <div class="form-group">
                    <input type="text" id="studentID" name="studentID" class="form-control" placeholder="학번" required>
                </div>
                <div class="form-group">
                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="전화번호" required>
                </div>
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="이름" required>
                </div>
                <button type="button" onclick="sendData()" class="w-100 btn btn-lg btn-primary" style="background-color: #666;">다음</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
