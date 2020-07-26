<?php

session_start();

$email = $_SESSION['useremail'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

$res = mysqli_query($connect,$query);
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$res = $connect->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);
  $user_idx = $row['idx'];
  $name = $row['name'];

}

$count = $_POST['count'];

echo $count;
include 'many_upload.php';

//print_r($arr_image);

$str_arr_image = implode('#',$arr_image);   // db에 저장시킬 배열 값


//echo "<br>".$str_arr_image;


$title = $_POST['title'];
$content = $_POST['ir1'];
$date = date('Y-m-d H:i:s');  // 작성한 날짜
$isDeleted = 0;
$hit = 0;

$query = "insert into free_board (user_idx,name,title,content,image,date,isDeleted,hit)
values ('$user_idx','$name','$title','$content','$str_arr_image','$date','$isDeleted','$hit')";

mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$result = $connect->query($query);

if ($result) {
  ?><script>
    alert('작성완료');
    location.replace('free_board.php');
  </script>
  <?php
} else {
  echo "<script>
    alert('실패');
    history.back();
  </script>";
}

 ?>
