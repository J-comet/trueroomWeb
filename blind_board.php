<?php

//$email = $_POST['user_email']; //신고한사람의 이메일
$board_idx = $_POST['board_idx'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결

if (isset($board_idx)) {
//  $query = "SELECT * FROM member WHERE idx == $idx";    // member 의 모든 데이터를 조회

  mysqli_query($connect,"set names utf8");
  $query = "UPDATE reviewinfo SET isDeleted='1' WHERE idx='$board_idx'"; // 신고당한게시물의 idx 값과 idx 의 값이 같다면 isDeleted '1' 로 바꿈
  $result = mysqli_query($connect,$query);

}

if (isset($result)) {

    ?><script>
       alert('블라인드 처리');
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
