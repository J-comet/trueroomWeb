<?php
session_start();

$writer_email = $_SESSION['useremail'];
$receiver_email = $_POST['receiver_email'];
$title = $_POST['title'];
$content = $_POST['content'];
$date = date('Y-m-d H:i:s');  // 작성한 날짜

$question_status = 0;
$admin_answer = "없음";

//echo $writer_email."<br>";
//echo $receiver_email."<br>";
//echo $title."<br>";
//echo $content."<br>";
//echo $date."<br>";

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
//입력받은 데이터를 DB에 저장
$query = "insert into admin_question (writer_email,receiver_email,title,content,date,question_status,admin_answer)
values ('$writer_email','$receiver_email','$title','$content','$date','$question_status','$admin_answer')";

mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$result = $connect->query($query);

if ($result) {
  ?><script>
    alert('문의제출');
    location.replace('myquestion.php');
  </script>
  <?php
} else {
  echo "<script>
    alert('제출실패');
    history.back();
  </script>";
}

 ?>
