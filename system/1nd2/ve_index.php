<?php
session_start();
?>
<?php
if (!isset($_COOKIE['veting_manager'])) {
    header("Location: /index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>선택 완료</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="2;url=/index.php">
  <style>
    #progress-bar {
      width: 100%;
      height: 10px;
      background-color: #f1f1f1;
      position: fixed;
      top: 0;
      left: 0;
    }

    #progress-bar-inner {
      height: 100%;
      background-color: #1ECD97;
      width: 0%;
    }

    body {
        display:flex;
        flex-direction :column;
        align-items:center;
        justify-content:center;
        height :100vh; 
     }

     h1 {
         text-align:center; 
         margin-top :20px; 
     }

     .button {
         display:inline-block; 
         padding :10px 20px; 
         background-color:#1ECD97; 
         color:white; 
         border-radius :50px;  
         text-decoration:none; 
         font-size :16px ;  
     }

     .button:hover{
          opacity :0.8 ;  
     }

     .button:focus{
          outline:none ;  
     }

     .button-container{
          margin-top :20px;;  
       }
   </style>
</head>
<body>

<div id="progress-bar">
   <div id="progress-bar-inner"></div>
</div>

<h1>베팅 완료</h1>

<div class="button-container">
   <a href="#" class="button">메인페이지로 이동하기</a>
</div>

<script type="text/javascript">
function updateProgressBar() {
   var progressBar = document.getElementById('progress-bar-inner');
   var progress = setInterval(frame,30);
   var width = 0;

   function frame() {
       if (width >=100) {
           clearInterval(progress);
       } else {
           width++;
           progressBar.style.width = width + '%';
       }
   }
}

setTimeout(updateProgressBar,500);
</script>

</body>
</html>
