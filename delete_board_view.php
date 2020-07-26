<?php

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$bno =$_GET['idx'];   //reviewinfo 의 idx 값

$query = "DELETE FROM reviewinfo WHERE idx ='{$bno}'"; // idx 로 해당게시물을 찾음
$query1 = "DELETE FROM user_declare WHERE board_num ='{$bno}'"; // 신고한 게시글의 db 에서도 삭제시켜주기

$result = mysqli_query($connect,$query);

if (isset($result)){

?>
   <script>
  alert('삭제완료');
  location.replace("review_board.php");
  </script>
<?php
} else {
  ?>
  <script>
  alert('삭제실패');
  location.replace("review_board.php");
  </script>
<?php
}
 ?>
