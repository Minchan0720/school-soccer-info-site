$(document).ready(function(){
    $("#more-link").click(function(e){
        e.preventDefault();
        $("#team-members").toggle();
        e.stopPropagation(); // 이벤트 버블링을 방지합니다.
    });

    $("#more-link-b").click(function(e){
        e.preventDefault();
        $("#team-members-b").toggle();
        e.stopPropagation(); // 이벤트 버블링을 방지합니다.
    });

    $(document).click(function() {
        // "더보기" 링크 외의 다른 곳을 클릭하면 모든 펼쳐진 목록들이 접힙니다.
        $("#team-members:visible, #team-members-b:visible").hide();
    });
});



$(document).ready(function() {
    // 기타 코드 생략

    var textIndex = 0;
    var textArray = ['베팅하실 반을 클릭!', '베팅금액을 입력!!', '선택완료를 눌러 베팅!']; // 원하는 텍스트 배열

    setInterval(function() {
        $('#title-text').text(textArray[textIndex]);
        textIndex++;
        if (textIndex >= textArray.length) {
            textIndex = 0;
        }
    }, 3000); // 2초 간격으로 실행
});

