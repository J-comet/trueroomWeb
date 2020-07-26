
<?php

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$board_idx = $_POST['idx'];
$board_title = $_POST['title'];
$reply_idx = $_POST['reply_idx']; // 댓글의 고유 idx 값

$reply_modify_content = $_POST['reply_modify_content'];  // 수정내용

$update_date = date('Y-m-d H:i:s');  // 수정한 날짜

/*
echo $reply_idx."<br>";
echo $reply_modify_content."<br>";
echo $update_date."<br>";
*/

mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

$reply_sql = "update reply set content = '$reply_modify_content', update_date = '$update_date' where idx = '$reply_idx'";
$result = $connect->query($reply_sql);

//echo $reply_idx."<br>";

if (isset($result)){

?>
   <script>
  alert('댓글수정');
  // 삭제후 게시물로 돌아감
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
} else {
  ?>
  <script>
  alert('댓글수정 실패');
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
}
 ?>
