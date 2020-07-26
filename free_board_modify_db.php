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
  $idx = $row['idx'];
  $name = $row['name'];

}

include 'many_upload.php';


$str_arr_image = implode('#',$arr_image);   // db에 저장시킬 배열 값

//echo "<br>".$str_arr_image;

$title = $_POST['title'];
$content = $_POST['ir1'];
$bno = $_POST['idx'];

$image = $_POST['tmpfile'];

$image = implode("#",$image);

$date = date('Y-m-d H:i:s');  // 작성한 날짜
$isDeleted = 0;
$hit = 0;

$image .= "#".$str_arr_image;

/*
echo $bno."<br>";
echo $title."<br>";
echo $content."<br>";

echo "추가된 이미지 값들".$str_arr_image."<br>";
//print_r($image)."<br>";
echo "총 이미지".$image;
*/

mysqli_query($connect,"set names utf8");

$quer = "update free_board set date='$date',title='$title', content='$content', image='$image' where idx='$bno'";

$resul = $connect->query($quer);

if (isset($resul)) {
 ?>
 <script>
   alert('수정완료');
   history.go(-2);
   //location.replace("sellhome.php");
 </script>

<?php
} else {
    echo "<script>
       alert('실패');history.go(-1);
      </script>";

 }

 ?>
