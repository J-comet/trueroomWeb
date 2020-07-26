<?php


$give_user = $_POST['session_idx'];
$receive_user = $_POST['member_idx'];
$board_num = $_POST['board_idx'];


$singo_item = implode(',',$_POST['chk_singo']); // 신고 다중체크박스 배열 값

$true_singo = $_POST['singo_input'];   // 직접입력 체크박스 값

$input_singo = $_POST['singotextarea'];   // textarea 의 값

$save_singo;   // db 에 저장시킬 신고사유

if (isset($true_singo)) {
  $save_singo = $input_singo;
} else {
  $save_singo = $singo_item;
}

$date = date('Y-m-d H:i:s');

/*
echo $give_user."<br>";
echo $receive_user."<br>";
echo $board_num."<br>";
echo $save_singo."<br>";
echo $date."<br>";
*/

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
$query = "insert into user_declare (give_user,receive_user,board_num,issue,date) values ('$give_user','$receive_user','$board_num','$save_singo','$date')";
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$result = $connect->query($query);

if (isset($result)) {
 ?>
 <script>
   alert('신고했습니다');
   history.back();
   //location.replace("review_board.php");
 </script>

<?php
} else {
    echo "<script>
       alert('실패');history.back();
      </script>";

 }

 ?>
