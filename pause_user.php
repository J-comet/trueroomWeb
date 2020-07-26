<?php

$email = $_POST['user_email'];
$idx = $_POST['user_idx'];


$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결

if (isset($idx)) {
//  $query = "SELECT * FROM member WHERE idx == $idx";    // member 의 모든 데이터를 조회

  mysqli_query($connect,"set names utf8");
  $query = "UPDATE member SET account_pause='1' WHERE idx='$idx'";
  $result = mysqli_query($connect,$query);

}

if (isset($result)) {

    ?><script>
       alert('<?php echo $email; ?> 계정정지');
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
