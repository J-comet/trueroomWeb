<?php

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$board_idx = $_POST['idx'];
$board_title = $_POST['title'];

$user_idx = $_POST['user_idx'];
$reply_content = $_POST['reply_content'];
$date = date('Y-m-d H:i:s');  // 작성한 날짜

mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

$reply_sql = "insert into reply (board_idx, user_idx, content, date) values ('$board_idx', '$user_idx', '$reply_content', '$date')";
$result = $connect->query($reply_sql);

//echo $reply_idx."<br>";

if (isset($result)){

?>
   <script>
  alert('댓글등록');
  // 삭제후 게시물로 돌아감
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
} else {
  ?>
  <script>
  alert('댓글등록 실패');
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
}
 ?>
