<?php

$db = mysqli_connect("localhost","root","gptjd7848","trueroom")or die("fail");

$db->set_charset("utf8");

function mq($sql){
  global $db;
  return $db->query($sql);
}


$email = $_POST['useremail'];

// db저장할 때 세션의 이메일값 삭제시켜줌
unset($_SESSION['dbemail']);


$name = $_POST['username'];
$password = $_POST['password'];
$pwcheck = $_POST['pwCheck'];
$gender = $_POST['gender'];
$company_name = $_POST['usercompany'];
$what_service = $_POST['what_service'];

$favorite_place = 0;  // 기업사원은 해당사항 없음
$favorite_job = 0;  // 기업사원은 해당사항 없음

//echo $favorite_place.$favorite_job;

$date = date('Y-m-d H:i:s');  // 가입한 날짜
$account_pause = 0;    // 탈퇴한 유저인지 나중에 확인하기 위해  0 이면 거짓 1 이면 참
$admin =0; // 관리자계정을 위한 변수
//$phone = null;
$verify = 1;



// email 중복체크 기능
$id_check = mq("select * from member where email='$email'");
$id_check = $id_check->fetch_array();
if($id_check >= 1){
  echo "<script>alert('아이디가 중복됩니다'); history.back();</script>";
} elseif ($password != $pwcheck) {
    echo "<script>alert('비밀번호가 일치하지않습니다'); history.back();</script>";
} elseif (preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i',$email) == false) {
    echo "<script>alert('이메일 양식에 맞지않습니다'); history.back();</script>";
} elseif (preg_match('/^[가-힣]+$/',$name) == false) {
    echo "<script>alert('닉네임 양식에 맞지않습니다'); history.back();</script>";
}
else {

  $sql = "insert into member (email,password,name,gender,date,favorite_place,favorite_job,account_pause,admin,verify,company_name,what_service)
  values('$email','$password','$name','$gender','$date','$favorite_place','$favorite_job','$account_pause','$admin','$verify','$company_name','$what_service')";

  mysqli_query($db,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $result = $db->query($sql);


}


//저장이 되었다면 (result = true) 가입완료
if ($result) {
  ?>
  <script>
    alert('가입완료');
    location.replace("index.php");
  </script>

  <?php
}          else {
          ?>   <script>
                alert('실패');
                history.back();
               </script>
<?php  }
   mysqli_close($db);

 ?>
