<?php
session_start();

if(!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: ../anti_admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Noisy IT 재고 관리 시스템</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery CDN -->

    <style>
        .table-responsive {
            margin-top: 20px;
        }

        .btn {
            margin: 5px;
            padding: 5px;
            font-size: 14px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

      @media (max-width: 576px) {
          .table td {
              max-width: none;
          }
      }

      .low-stock {
          background-color: yellow !important;
      }

      .out-of-stock {
          background-color: red !important; 
      }
     </style>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery CDN -->
</head>

<body class='bg-light'>
<div class='container py-5'>
  <div class="d-flex justify-content-center align-items-center">
    <h2 class='mb-4' id="title-text">Noisy IT 재고 관리 시스템</h2>
    <a href="plus.php" class="btn btn-success ml-3">재고 추가</a>
  </div>



<div class='table-responsive'>
<table id="inventory-table" class='table table-striped table-bordered text-center' style='font-size: 20px;'>

<tr>
<th>제품</th>
<th>총 수량</th>
<th id="sold-today">오늘 판매된 수량</th>
<th id="remaining-today">오늘 남은 판매 수량</th>
</tr>


</table></div>

<div class='my-3 p-3 bg-white rounded shadow-sm'>
  <h6 class='border-bottom border-gray pb-2 mb-0'>상품 판매하기:</h6>

  <!-- 입력칸 -->
<div class = 'd-flex flex-column align-items-start justify-content-between my-3' >
    <input type="text" id="product-name-input" placeholder="학번을 입력하세요" style ='width:100%; margin-bottom:10px;' />

    <!-- 다이얼식 선택 버튼 -->
    <select id ="quantity-select" style ='width :100%; margin-bottom :20px; ' >
        <option value="">상품 선택...</option>
    </select >

     <!-- 상품 선택응 가져오는걸로 함 js 로 -->
     <button type ="button " id = "sell-button"class ='btn btn-primary' style = 'width :100% ; '>판매하기 </button >

</div >
  
<div id="log-container">
    <h3>최근 결제 로그:</h3>
    <ul id="log-list"></ul>
</div>

</div>
<script>
$("#sell-button").click(function() {
    var username = $("#product-name-input").val();
    var product = $("#quantity-select").val();

    $.getJSON('users.json', function(users) {
        var user = users.find(u => u.username === username);

        if (user) {
            $.getJSON('data.json', function(inventory) {
                var item = inventory[product];

                if (item && item.remainingSalesToday > 0 && user.point >= item.point) { // Check if the user has enough points
                    user.point -= item.point; // Deduct the price of the product from the user's points
                    item.remainingSalesToday--;

                    Promise.all([
                        $.ajax({
                            url: 'updateUser.php',
                            type: 'POST',
                            data: {username: username, point: user.point}
                        }),
                        $.ajax({
                            url: 'updateInventory.php',
                            type: 'POST',
                            data: {name: product, quantity: item.remainingSalesToday}
                        })
                    ]).then(function() {
                        alert("정상 처리되었습니다.");
                        
                        // Add log sss
                        sellProduct(product);
                        
                    }).catch(function() {
                        alert("처리 중 오류가 발생했습니다.");
                    });
                } else if (!item || item.remainingSalesToday <= 0){
                    alert("상품이 품절되었습니다!");
                } else if(user.point < item.point){
                  alert("포인트 부족.");
                }
            });
        } else {
            alert("학번이 잘못되었습니다.");
        }
    });
});
</script>

<script>
// 페이지 로딩 완료 후 실행
$(document).ready(function() {
  // data.json 파일에서 상품 이름 가져오기
  $.getJSON('data.json', function(data) {
      var select = $('#quantity-select');
      // 각각의 상품 이름을 option 값으로 추가
      Object.keys(data).forEach(function(key) {
          select.append($('<option>', { 
              value: key,
              text : key 
          }));
      });
  });
});
</script>
<script>
$(document).ready(function() {
    if (window.innerWidth <= 576) { // 모바일 환경 확인
        $("#title-text").text("재고관리"); // 제목 변경
        $("#sold-today").text("오늘판매량"); // 테이블 헤더 변경
        $("#remaining-today").text("당일남은"); // 테이블 헤더 변경
        $("#sell-button").text("판"); // 버튼 텍스트 변경 
      /// 추가할꺼 있으면 추가하기 - > 반응형 구축
    }
});
</script>

<script src="namun.js"></script>
</body></html>
