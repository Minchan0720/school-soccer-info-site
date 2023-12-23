
function updateTable() {

$.getJSON("inventory.php", function(data) {

  $.each(data, function(key,value){
      var remainingSalesToday = value.remainingSalesToday;
      $('#'+key+'-totalQuantity').text(value.totalQuantity);
      $('#'+key+'-soldToday').text(value.soldToday);
      $('#'+key+'-remainingSalesToday').text(remainingSalesToday);

      if (remainingSalesToday <= 30 && remainingSalesToday > 10) {
          $('#'+key+'-remainingSalesToday').addClass('low-stock');
      } else if (remainingSalesToday <= 10) {
          $('#'+key+'-remainingSalesToday').addClass('out-of-stock');
      } else {
          $('#'+key+'-remainingSalesToday').removeClass('low-stock out-of-stock');
      }
  });
});
}


setInterval(updateTable, 1000);


function sellProduct(product) {


   $.post("sell.php", { "product": product }, function(data) {
       if (data === "out of stock") {
           alert(product + "의 재고가 더 이상 없습니다.");
       } else {
           var currentTime = new Date().toLocaleTimeString();
           var logMessage = product + " 1개가 " + currentTime + "에 구매되었습니다.";
           
           var logList = document.getElementById("log-list");
           var logItem = document.createElement("li");
           logItem.textContent = logMessage;
           

           if (logList.childElementCount >= 5) {
               logList.removeChild(logList.firstChild);
           }
           
           logList.appendChild(logItem);


            $.post("buyer.php", { "message": logMessage });
        }
    });

}

$(document).ready(function() {

var products = ["cola", "cider", "snacks", "환타", "베이직", "쿨라", "쿨", "수박", "아이스크림"];

$.each(products, function(index, value){

  $('#inventory-table').append('<tr><td>' + value 
                               + '</td><td id="' + value + '-totalQuantity"></td><td id="' 
                               + value + '-soldToday"></td><td id="' 
                               + value+ '-remainingSalesToday"></td>'
                               + '<td><button onclick="sellProduct(\''+value+'\')" class=\'btn btn-primary\'>판매하기</button></td></tr>');

  });

 updateTable();
});