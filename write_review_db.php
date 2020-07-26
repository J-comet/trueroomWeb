<?php

session_start();


$member_idx = $_POST['memberidx'];  // 멤버 테이블의 idx 값을 저장 시키기 위한 변수
$email = $_SESSION['useremail'];  // 현재 작성하고 있는 사용자의 이메일

$company_name = $_POST['company_name'];
$check_work = $_POST['check_work'];
$what_job = $_POST['what_job'];
$how_work = $_POST['how_work'];
$how_long = $_POST['how_long'];
$where_work = $_POST['where_work'];
$company_money = $_POST['company_money'];
$oneline= $_POST['oneline'];
$advantage = $_POST['advantage'];
$dis_advantage = $_POST['dis_advantage'];
$company_required = $_POST['company_required'];

$chance_possible = $_POST['chance_possible_rating'];
$health_money= $_POST['health_money_rating'];
$work_life = $_POST['work_life_rating'];
$in_company = $_POST['in_company_rating'];
$operate = $_POST['operate_rating'];

$total = ($chance_possible + $health_money + $work_life + $in_company + $operate) / 5;

$name = $_POST['username'];
$gender = $_POST['gender'];

$date = date('Y-m-d H:i:s');  // 날짜
$isDeleted = 0;

if ($total != '') {
  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
  //입력받은 데이터를 DB에 저장
  $query = "insert into reviewinfo (member_idx,company_name,check_work,what_job,how_work,how_long,where_work,company_money,oneline,advantage,dis_advantage
  ,company_required,chance_possible,health_money,work_life,in_company,operate,total,gender,email,name,date,isDeleted)
  values ('$member_idx','$company_name','$check_work','$what_job','$how_work','$how_long','$where_work','$company_money','$oneline','$advantage','$dis_advantage',
  '$company_required','$chance_possible','$health_money','$work_life','$in_company','$operate','$total','$gender','$email','$name','$date','$isDeleted')";

  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $result = $connect->query($query);
} else {
  echo "<script>
     alert('모든 별점을 선택해주세요');
     history.back();
    </script>";
}



//저장이 되었다면 (result = true) 가입완료
if (isset($result)) {
 ?>
 <script>
   alert('게시글작성 완료');
   location.replace("review_board.php");
 </script>

<?php
} else {
    echo "<script>
       alert('모든 칸을 입력해주세요');history.back();
      </script>";

 }

 ?>
