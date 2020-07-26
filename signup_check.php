
<?php
session_start();
header('Content-Type: text/html; charset=utf-8');


$email = $_POST['useremail'];
$password = $_POST['userpassword'];
$password2 = $_POST['pwCheck'];
$name = $_POST['username'];

$date = date('Y-m-d H:i:s');  // 가입한 날짜
$isDeleted = 0;    // 탈퇴한 유저인지 나중에 확인하기 위해  0 이면 거짓 1 이면 참
$admin =0; // 관리자계정을 위한 변수

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom");

if (isset($email)) {
  $query ="SELECT * FROM member WHERE email ='$email'";

   $result = mysqli_query($connect,$query);
   if (mysqli_num_rows($result) > 0) {   // 이메일이 중복될때
           echo "emailFalse";
   } else if ($password != $password2) { // 비밀번호가 불일치할때
     echo "pwFalse";
   }
   else {

     $sql = "insert into member (email,password,name,date,isDeleted,admin)
     values('$email','$password','$name','$date','$isDeleted','$admin')";

     mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
     $result = $connect->query($sql);

     if (isset($result)) {
      echo "success";
     }

   }
}







 ?>
