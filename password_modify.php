<?php


$db = new mysqli("localhost","root","gptjd7848","trueroom");
$db->set_charset("utf8");

function mq($sql)
{
  global $db;
  return $db->query($sql);
}


session_start();

$useremail = $_SESSION['useremail'];  // 세션에 저장되어있는 id 값으로 기존비밀번호 가져오기

$before_pw = $_POST['beforepw'];
$new_pw = $_POST['newpw'];
$pw_check = $_POST['pw_check'];


if ($useremail != '') {    // 세션에 저장되어 있는 이메일가 있다면

  $query = "SELECT * FROM member WHERE email ='{$useremail}'"; // 이메일로 해당게시물을 찾음

  $res = mysqli_query($db,$query);
  mysqli_query($db,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $db->query($query);

  if($res->num_rows >= 1) {   // 일치하는 이메일 있다면 실행
    $row = mysqli_fetch_array($res);
    $password = $row['password'];  //db에 저장되어 있는 값
  }
}



if ($password != $before_pw ) {
  echo "<script>alert('기존 비밀번호 불일치'); history.back();</script>";
} elseif ($new_pw != $pw_check) {
    echo "<script>alert('비밀번호 확인 불일치'); history.back();</script>";
} elseif (preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,16}$/',$new_pw) == false) {
    echo "<script>alert('영문,숫자조합으로 8~16자로 입력'); history.back();</script>";
} else {

mysqli_query($db,"set names utf8");
$sql = "update member set password='$new_pw' where email='$useremail'";

 $result = $db->query($sql);
}


 if (isset($result)) {
   echo "<script>alert('변경완료'); location.replace('password_page.php');</script>";
 } else {
   echo "<script>alert('변경실패'); history.back();</script>";
 }

 ?>
