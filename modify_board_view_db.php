<?php

$bno =$_POST['hidden_idx'];
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
if ($chance_possible == '') {
  $chance_possible = $_POST['hidden_chance_possible'];
}

$health_money= $_POST['health_money_rating'];
if ($health_money == '') {
  $health_money = $_POST['hidden_health_money'];
}

$work_life = $_POST['work_life_rating'];
if ($work_life == '') {
  $work_life = $_POST['hidden_work_life'];
}

$in_company = $_POST['in_company_rating'];
if ($in_company == '') {
  $in_company = $_POST['hidden_in_company'];
}

$operate = $_POST['operate_rating'];
if ($operate == '') {
  $operate = $_POST['hidden_operate'];
}

$total = ($chance_possible + $health_money + $work_life + $in_company + $operate) / 5;

//$name = $_POST['username'];
//$gender = $_POST['gender'];

$date = date('Y-m-d H:i:s');  // 날짜



$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
mysqli_query($connect,"set names utf8");
$sql = "update reviewinfo set company_name='$company_name',check_work='$check_work',check_work='$check_work'
,what_job='$what_job',how_work='$how_work',how_long='$how_long',where_work='$where_work',company_money='$company_money'
,oneline='$oneline',advantage='$advantage',dis_advantage='$dis_advantage',company_required='$company_required',chance_possible='$chance_possible'
,health_money='$health_money',work_life='$work_life',in_company='$in_company',operate='$operate',total='$total'
 where idx='$bno'";

 $result = $connect->query($sql);

 if (isset($result)) {
 ?>
 <script>
    alert('수정완료');
    history.go(-2);  // 현재페이지 새로고침
 </script>
 <?php
 }

  ?>
<!--
echo $company_name."<br>";
echo $check_work."<br>";
echo $what_job."<br>";
echo $how_work."<br>";
echo $how_long."<br>";
echo $where_work."<br>";
echo $oneline."<br>";
echo $advantage."<br>";
echo $dis_advantage."<br>";
echo $company_required."<br>";
echo $chance_possible."<br>";
echo $health_money."<br>";

echo $work_life."<br>";
echo $in_company."<br>";

echo $operate."<br>";
echo $total."<br>";
echo $date."<br>";
-->
