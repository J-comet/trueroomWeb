<?php

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$bno =$_GET['idx'];

$query = "DELETE FROM reviewinfo WHERE idx ='{$bno}'"; // idx 로 해당게시물을 찾음
$result = mysqli_query($connect,$query);

if (isset($result)){

?>
   <script>
  alert('삭제완료');
  location.replace("mypost.php");
  </script>
<?php
} else {
  ?>
  <script>
  alert('삭제실패');
  location.replace("mypost.php");
  </script>
<?php
}
 ?>
