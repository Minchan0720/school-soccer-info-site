    function loadUserPoints() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const username = "<?php echo $_SESSION['username']; ?>";
                const users = JSON.parse(this.responseText);
                for (const user of users) {
                    if (user.username === username) {
                        document.getElementById("profilePText").innerHTML = user.point + 'p';
                        break;
                    }
                }
            }
        };
        xhttp.open("GET", "./login/users.json", true);
        xhttp.send();
    }

    setInterval(loadUserPoints, 10000); // 3초마다 함수 호출 새로고침 // 3초마다 포인트 가져옴 서버 과부하 때문에 3초로 추후 조정 10초로 결정