<?php


$email = $_POST['useremail'];
$name = $_POST['username'];
$gender = $_POST['gender'];
$favorite_place = $_POST['favorite_place'];
$favorite_job = $_POST['favorite_job'];

//echo $name;

$db = new mysqli("localhost","root","gptjd7848","trueroom");
$db->set_charset("utf8");

function mq($sql)
{
  global $db;
  return $db->query($sql);
}



$query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

$res = mysqli_query($db,$query);
mysqli_query($db,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$res = $db->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);

  $idx = $row['idx'];
  $rowname = $row['name'];

}

$name_check = mq("SELECT * FROM member WHERE name='{$name}' AND name != '{$rowname}'");
$name_check = $name_check->fetch_array();

if (preg_match('/^[가-힣]+$/',$name) == false) {
    echo "<script>alert('한글만입력가능'); history.back();</script>";
}
/*
현재 닉네임과 같은지 검사해버리면 다른 값들을 수정할 때 닉네임도 필수적으로 수정을 해야되서
닉네임은 그대로두고 다른 걸 수정하고 싶은 유저가 있다면 해당 유저에게 피해가 발생

elseif ($rowname == $name) {
    echo "<script>alert('현재닉네임과 같습니다'); history.back();</script>";
}
*/

elseif ($rowname != $name) {   // 바꾸려는 닉네임이 현재 내 닉네임이 아니라면 중복검사를 실시
  if($name_check >= 1){
           echo "<script>alert('중복되는 닉네임'); history.back();</script>";
  } else {
    $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
    mysqli_query($connect,"set names utf8");
    $sql = "update member set name='$name',gender='$gender', favorite_place='$favorite_place', favorite_job='$favorite_job' where email='$email'";

     $result = $connect->query($sql);  // $result 는 member 테이블의 업데이트 성공했는지 확인하는 결과값

     mysqli_query($connect,"set names utf8");
     $sql2 = "update reviewinfo set name='$name',gender='$gender' where member_idx='$idx'";

      $result2 = $connect->query($sql2);  // $result2 는 reviewinfo 테이블의 업데이트가 성공했는지 확인하는 결과값
  }
}

else {
 $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
 mysqli_query($connect,"set names utf8");
 $sql = "update member set name='$name',gender='$gender', favorite_place='$favorite_place', favorite_job='$favorite_job' where email='$email'";

  $result = $connect->query($sql);  // $result 는 member 테이블의 업데이트 성공했는지 확인하는 결과값

  mysqli_query($connect,"set names utf8");
  $sql2 = "update reviewinfo set name='$name',gender='$gender' where member_idx='$idx'";

   $result2 = $connect->query($sql2);  // $result2 는 reviewinfo 테이블의 업데이트가 성공했는지 확인하는 결과값

}

if (isset($result) && isset($result2)) {
?>
<script>
   alert('수정완료');
   history.back();
</script>
<?php
} else {
  ?>
  <script>
     alert('fail');
     history.back();
  </script>
  <?php
}

 ?>
