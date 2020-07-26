<?php

//$email = $_POST['user_email'];
$board_idx = $_POST['board_idx'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결

if (isset($board_idx)) {
//  $query = "SELECT * FROM member WHERE idx == $idx";    // member 의 모든 데이터를 조회

  mysqli_query($connect,"set names utf8");
  $query = "UPDATE reviewinfo SET isDeleted='0' WHERE idx='$board_idx'";
  $result = mysqli_query($connect,$query);

}

if (isset($result)) {

    ?><script>
       alert('블라인드 해제');
         history.back();
       //location.replace('true_admin.php');  // 현재페이지 새로고침
    </script><?php
} else {
  echo "<script>
  alert('실패');
  history.back();
  </script>";

}

 ?>
