// 1학년 대진표 페이지 바로가기
function openGrade() {
    window.location.href = 'system/1nd2/step_engine.php';
}
// 2학년 대진표 페이지 바로가기
function games() {
    window.location.href = 'game/all_game.php';
}
// 상품 추첨 페이지 바로가기
function openGift() {
    window.location.href = 'view/point/ns_shop.php';
}
// 메인페이지 돌아가기(NoisyIT 로고 클릭)
function HomeBtn() {
    window.location.href = 've_index.php';
}
// 커뮤니티 돌아가기
function clmu() {
    window.location.href = 'comunity/comunity.php';
}
// 내정보 acocunt 돌아가기
function mine() {
    window.location.href = 'login/help-ac.php';
}
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/today_team.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "1st_1" 키의 값 가져와서 팀1-a의 내용으로 설정
            var team1A = data['1st']['1st_1'];
            var team1ADiv = document.getElementById('team1-a');
            team1ADiv.textContent = team1A;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/today_team.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "1st_1" 키의 값 가져와서 팀1-a의 내용으로 설정
            var team1A = data['1st']['1st_2'];
            var team1ADiv = document.getElementById('team1-b');
            team1ADiv.textContent = team1A;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/today_team.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "1st_1" 키의 값 가져와서 팀1-a의 내용으로 설정
            var team1A = data['2st']['2st_1'];
            var team1ADiv = document.getElementById('team2-a');
            team1ADiv.textContent = team1A;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/today_team.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "1st_1" 키의 값 가져와서 팀1-a의 내용으로 설정
            var team1A = data['2st']['2st_2'];
            var team1ADiv = document.getElementById('team2-b');
            team1ADiv.textContent = team1A;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/live_core.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "live_core1" 키의 값을 가져와서 score1-1의 내용으로 설정
            var liveCore1 = data['1st']['live_core1'];
            var score1_1Div = document.getElementById('score1-1');
            score1_1Div.textContent = liveCore1;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/live_core.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "live_core1" 키의 값을 가져와서 score1-1의 내용으로 설정
            var liveCore1 = data['1st']['live_core12'];
            var score1_1Div = document.getElementById('score1-2');
            score1_1Div.textContent = liveCore1;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/live_core.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "live_core1" 키의 값을 가져와서 score1-1의 내용으로 설정
            var liveCore1 = data['2st']['live_core2'];
            var score1_1Div = document.getElementById('score2-1');
            score1_1Div.textContent = liveCore1;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('system/1nd2/live_core.json')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "live_core1" 키의 값을 가져와서 score1-1의 내용으로 설정
            var liveCore1 = data['2st']['live_core22'];
            var score1_1Div = document.getElementById('score2-2');
            score1_1Div.textContent = liveCore1;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
document.addEventListener("DOMContentLoaded", function () {
    // JSON 파일에서 데이터를 가져옴
    fetch('comunity/notice.json') // JSON 파일 경로를 변경
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // JSON 데이터에서 "noticeText" 키의 값을 가져와서 출력할 div 요소에 설정
            var noticeText = data.noticeText;
            var noticeDiv = document.getElementById('lec1-notice');
            noticeDiv.textContent = noticeText;
        })
        .catch(function (error) {
            // 에러 처리
            console.error('데이터를 가져오는 중 에러 발생: ' + error);
        });
});
