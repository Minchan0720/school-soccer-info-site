<!DOCTYPE html>
<html>
<head>
    <title>회원 캐쉬</title>
    <script>
        // 포인트 조회 함수
        function searchPoints() {
            // 입력된 학번 가져오기
            var username = document.getElementById("username").value;
          
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/../../login/users.json", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var users = JSON.parse(xhr.responseText);
                    var user = users.find(function (u) {
                        return u.username === username;
                    });
                    if (user) {
                        document.getElementById("current_points").textContent = "현재 포인트: " + user.point;
                    } else {
                        document.getElementById("current_points").textContent = "사용자를 찾을 수 없습니다.";
                    }
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <form method="post">
        <h2>회원 캐쉬</h2>
        <div class="form-group">
            <label for="username">학번</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="학번" required>
        </div>
        <div class="form-group">
            <label for="points">포인트 수정</label>
            <input type="number" id="points" name="points" class="form-control" placeholder="포인트 수정" required>
        </div>
        <div class="form-group">
            <label for="current_points">현재 포인트</label>
            <span id="current_points"></span>
        </div>
        <div class="form-group">
            <button type="button" onclick="searchPoints();">포인트 조회</button>
            <input type="submit" value="포인트 수정">
        </div>
    </form>
</body>
</html>
