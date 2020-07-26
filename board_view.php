<?php
session_start();


$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$bno = $_GET['idx'];
$query = "SELECT * FROM reviewinfo WHERE idx ='{$bno}'"; // idx 로 해당게시물을 찾음

$res = mysqli_query($connect,$query);
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글 x
$res = $connect->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);

  $board_idx = $row['idx'];   // 게시물의 idx
  //$member_idx = $row['member_idx']; // 작성자의 idx 값

  $write_email = $row['email'];  // 작성자의 이메일
  $write_name = $row['name']; //작성자의 닉네임
  $company_name = $row['company_name'];
  $check_work = $row['check_work'];
  $what_job = $row['what_job'];
  $how_work = $row['how_work'];
  $how_long = $row['how_long'];
  $where_work = $row['where_work'];
  $company_money = $row['company_money'];
  $oneline= $row['oneline'];
  $advantage = $row['advantage'];
  $dis_advantage = $row['dis_advantage'];
  $company_required = $row['company_required'];
  $chance_possible = $row['chance_possible'];
  $health_money= $row['health_money'];
  $work_life = $row['work_life'];
  $in_company = $row['in_company'];
  $operate = $row['operate'];
  $total = $row['total'];
  $gender = $row['gender'];
  $date = $row['date'];
  $blind = $row['isDeleted'];

  ///////////////////////////////////////////
  // 기업연봉 직접 보여주지 말고 xxxx만원대 초반 중반 후반 으로 바꾸어 보여주기

  if ($company_money < 1000) {                       // 0~999
    $company_money = "1000만원대 미만";
  } elseif (1000 <= $company_money && $company_money < 1400) {  // 1000 이상 1400미만  1000 ~ 1399
    $company_money = "1000만원대 초반";
  } elseif (1400 <= $company_money && $company_money < 1700) {  // 1400 이상 1700미만 1400 ~ 1699
    $company_money = "1000만원대 중반";
  } elseif (1700 <= $company_money && $company_money < 2000) {  // 1700 이상 2000미만 1700 ~ 1999
    $company_money = "1000만원대 후반";
  } elseif (2000 <= $company_money && $company_money < 2400) {  // 2000 이상 2400미만 2000 ~ 2399
    $company_money = "2000만원대 초반";
  } elseif (2400 <= $company_money && $company_money < 2700) {  // 2400 이상 2700미민 2400 ~ 2699
    $company_money = "2000만원대 중반";
  } elseif (2700 <= $company_money && $company_money < 3000) {  // 2700 이상 3000미만 2700 ~ 2999
    $company_money = "2000만원대 후반";
  } elseif (3000 <= $company_money && $company_money < 3400) {  // 3000 이상 3400미만 3000 ~ 3399
    $company_money = "3000만원대 초반";
  } elseif (3400 <= $company_money && $company_money < 3700) {  // 3400 이상 3700미만 3400 ~ 3699
    $company_money = "3000만원대 중반";
  } elseif (3700 <= $company_money && $company_money < 4000) {  // 3700 이상 4000미만 3700 ~ 3999
    $company_money = "3000만원대 후반";
  } elseif (4000 <= $company_money && $company_money < 4400) {  // 4000 이상 4400미만 4000 ~ 4399
    $company_money = "4000만원대 초반";
  } elseif (4400 <= $company_money && $company_money < 4700) {  // 4400 이상 4700미만 4400 ~ 4699
    $company_money = "4000만원대 중반";
  } elseif (4700 <= $company_money && $company_money < 5000) {  // 4700 이상 5000미만 4700 ~ 4999
    $company_money = "4000만원대 후반";
  } elseif (5000 <= $company_money && $company_money < 5400) {  // 5000 이상 5400미만 5000 ~ 5399
    $company_money = "5000만원대 초반";
  } elseif (5400 <= $company_money && $company_money < 5700) {  // 5400 이상 5700미만 5400 ~ 5699
    $company_money = "5000만원대 중반";
  } elseif (5700 <= $company_money && $company_money < 6000) {   // 5700 이상 6000미만 5700 ~ 5999
    $company_money = "5000만원대 후반";
  } elseif (6000 <= $company_money && $company_money < 6400) {  // 6000 이상 6400미만 6000 ~ 6399
    $company_money = "6000만원대 초반";
  } elseif (6400 <= $company_money && $company_money < 6700) {   // 6400 이상 6700미만 6400 ~ 6699
    $company_money = "6000만원대 중반";
  } elseif (6700 <= $company_money && $company_money < 7000) {  // 6700 이상 7000미만 6700 ~ 6999
    $company_money = "6000만원대 후반";
  } elseif (7000 <= $company_money && $company_money < 7400) {  // 7000 이상 7400미만 7000 ~ 7399
    $company_money = "7000만원대 초반";
  } elseif (7400 <= $company_money && $company_money < 7700) {  // 7400 이상 7700미만 7400 ~ 7699
    $company_money = "7000만원대 중반";
  } elseif (7700 <= $company_money && $company_money < 8000) {  // 7700 이상 8000미만 7700 ~ 7999
    $company_money = "7000만원대 후반";
  } elseif (8000 <= $company_money && $company_money < 8400) {   // 8000 이상 8400미만 8000 ~ 8399
    $company_money = "8000만원대 초반";
  } elseif (8400 <= $company_money && $company_money < 8700) {  // 8400 이상 8700미만 8400 ~ 8699
    $company_money = "8000만원대 중반";
  } elseif (8700 <= $company_money && $company_money < 9000) {  // 8700 이상 9000미만 8700 ~ 8999
    $company_money = "8000만원대 후반";
  } elseif (9000 <= $company_money && $company_money < 9400) {  // 9000 이상 9400미만 9000 ~ 9399
    $company_money = "9000만원대 초반";
  } elseif (9400 <= $company_money && $company_money < 9700) {  // 9400 이상 9700미만 9400 ~ 9699
    $company_money = "9000만원대 중반";
  } elseif (9700 <= $company_money && $company_money < 10000) {  // 9700 이상 10000미만 9700 ~ 9999
    $company_money = "9000만원대 후반";
  } elseif (10000 <= $company_money) {   // 1억이상
    $company_money = "1억 이상";
  } elseif (20000 <= $company_money) {   // 2억이상
    $company_money = "2억 이상";
  } elseif (30000 <= $company_money) {   // 3억이상
    $company_money = "3억 이상";
  } elseif (40000 <= $company_money) {  // 4억이상
    $company_money = "4억 이상";
  } elseif (50000 <= $company_money) {  // 5억이상
    $company_money = "5억 이상";
  } elseif (60000 <= $company_money) {  // 6억이상
    $company_money = "6억 이상";
  }
}
 ?>
 <?php


   $email = $_SESSION['useremail'];

   if (empty($email)) {
     echo "<script>
     alert('로그인한 사용자만 이용가능');
     history.back();
     </script>";
   }


   $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

   $query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

   $res = mysqli_query($connect,$query);
   mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
   $res = $connect->query($query);
   if($res->num_rows >= 1) {

     $row = mysqli_fetch_array($res);

     $session_idx = $row['idx'];
     $name = $row['name'];
     //$gender = $row['gender'];
     $admin = $row['admin'];
     $verify = $row['verify'];

     $account_pause = $row['account_pause'];

   }



    if ($account_pause == 1) {
     echo"
     <script>
     alert('관리자에의해 정지된 계정입니다');
     location.replace('index.php');
     </script>";
   }

  ?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link href="css/bootstrap.min.css" rel="stylesheet">
     <link href="css/board_view.css" rel="stylesheet">
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

     <title>진실의방</title>
 <style media="screen">
   #gnb:hover{cursor: pointer;}
   #sub{
     /*margin-left: 500px;*/
     list-style:none;
     text-decoration: none;
   }
   #sub a{
     text-decoration:none;
     color:#fff;
   }
   #sub a:hover{
     text-decoration:none;
     color:black;
   }

 </style>

   </head>
   <body>

     <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
       <a class="navbar-brand" href="index.php" style="margin-left:150px;margin-right:150px;">진실의방</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
       </button>

       <div class="collapse navbar-collapse" id="navbarColor01">
         <ul class="navbar-nav mr-auto">

             <li class="nav-item active">
               <a class="nav-link" href="index.php">홈</a>
             </li>
             <li class="nav-item active">
               <a class="nav-link" href="review_board.php">기업리뷰</a>
             </li>
             <li class="nav-item active">
               <a class="nav-link" href="free_board.php">소통공간</a>
             </li>
             <!--
             <li class="nav-item active">
               <a class="nav-link" href="recent_news.php">최근기사</a>
             </li>
           -->
             <li class="nav-item active">
               <a class="nav-link" href="admin_question.php">문의하기</a>
             </li>
</ul>


           <?php
             if (empty($_SESSION['useremail'])) {
              ?>
              <ul class="nav navbar-nav navbar-right" style="float:right;">

                <li class="nav-item active" style="margin-right:10px;">
                  <a href="signup_choice.php"><button class="btn btn-sm btn-light" href="#" style="margin-top:5px;">회원가입</button></a>
                </li>

                <li class="nav-item active" style="margin-right:70px;">
                  <a href="login.php"><button class="btn btn-sm btn-light" href="#" style="margin-top:5px; margin-right:10px" >로그인</button></a>
                </li>

              </ul>


            <?php   } else {
            ?>

            <?php
                if ($admin != 1) {

             ?>


    <ul class="nav navbar-nav navbar-right" style="margin-right:100px;">
            <li class="nav-item active">

              <div>

                <?php
                if ($verify == 0) {
                  ?>
                  <span class="badge badge-info" style="float: right; margin-top:3px;">일반회원</span>
                  <?php
                } else {
                  ?>
                  <span class="badge badge-success" style="float: right; margin-top:3px;">인증회원</span>
                  <?php
                } ?>

             <a id="gnb" class="nav-link" style="float: right; margin-top:3px;">
                 <p style="float:right; color:white;margin-right:2px; margin-left:5px;"><strong><?php echo "$name"; ?></strong> 님</p>

              <img class="rounded" src="image/user.png" style="float: right;width:25px;height:23px;">
              </a>
            </div>

             <ul id="sub" style="float:right;">
               <a href="mypage.php"><li id="mypage">마이페이지</li></a>

               <?php
         if ($verify == 1) {  //기업회원이라면
           ?>
          <a href="mypost.php"><li id="mypost">내 기업리뷰</li></a>
          <a href="freeboard_post.php"><li id="mypost">내가 쓴 소통글</li></a>
          <a href="myquestion.php"><li id="mypost">내 문의글</li></a>
           <?php
         } else {  // 일반회원이라면
           ?>
          <a href="freeboard_post.php"><li id="mypost">내가 쓴 소통글</li></a>
          <a href="myquestion.php"><li id="mypost">내 문의글</li></a>
           <?php
         }
                ?>

                 <a href="#"><li id="logoutbtn" class="logoutsubmit">로그아웃</li></a>
             </ul>
            </li>
            </ul>


        <!--
            <li class="nav-item active">
             <a href="#"><img class="rounded" src="image/bell.png" style="width:35px;height:35px;margin-top:5px;">
             <span class="badge badge-info" style="position:absolute; margin-right:2px;">0</span></a>
            </li>
       -->

          <?php } else {
            ?>
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item active" >
                  <strong>
                    <a id="gnb" class="nav-link" style="marin-right:50px;"><img class="rounded" src="image/user.png" style="width:30px;height:30px;margin-right:15px;"><?php echo "$name 님"; ?>
                      <span style="margin-right:100px"></span>
                    </a>
                  </strong>

               <ul id="sub">
                 <a href="true_admin.php">
                   <li>관리자페이지</li></a>
                     <a href="#">
                      <li id="logoutbtn" class="logoutsubmit">로그아웃</li>
                     </a>
               </ul>
              </li>
            </ul>

            <?php
          }
        } ?>

              <script>
                $(document).ready(function(){

                    $('#logoutbtn').click(function() {
                       var result = confirm('로그아웃하시겠습니까?');
                        if(result) {
                          //yes
                          location.replace('logout.php');
                        }
                          else {
                          ////no
                           }
                         });
                });

                ////////////////////////////////////////////////////

                //// dropdown menu function
                   $(function(){
                     $('#sub').hide(); // 초기 상태에서 서브메뉴를 숨김.
                     $('#gnb').click( function(){    //  zarox3님을 클릭하면 서브메뉴가 나옴
                        $('#sub').slideToggle();
                        //$('#sub').show();    .show 를 하게되면 한번눌렀을때 계속보이게된다.
                     });
                   });
              </script>

       </div>
     </nav>
 <!-- 네비바 끝나는 지점 -->

 <div class="jumbotron text-center">
   <h1>진실의방</h1>
   <p>이 회사는 어떤 곳이지?</p>
 </div> <br><br><br><br><br><br><br>



<!-- 모든 내용을 감싸줄 div -->
<div class="contain">

<!-- 사이드 내용인 왼쪽 부분 -->
  <div class="side">
    <p style="text-align:left"> <?php echo $date; ?> </p>
    <p style="text-align:left"><img class="rounded" src="image/user.png" style="width:30px;height:30px;margin-right:10px;"><?php echo $write_name; ?></p>
    <p style="text-align:left; color:gray; size:13px; margin-bottom:3px;"><?php echo $what_job; ?> | <?php echo $check_work; ?> | <?php echo $where_work; ?> | <?php echo $gender; ?></p>
    <p style="text-align:left; color:gray; size:13px">연봉 <?php echo $company_money; ?></p> <br><br>

    <p style="text-align:left; color:black; size:18px">승진 기회 및 가능성</p>
    <p>
      <?php
    for ($i=0; $i < $chance_possible ; $i++) {    // db 저장값을 불러와 저장값 만큼 체크된 버튼 반복해서 생성

     ?>
      <button type="button" class="star btn btn-primary">
        <i class="fa fa-star"></i>
    </button>
<?php  }
    for ($i=0; $i < ( 5 - $chance_possible) ; $i++) {   // 총 별의 개수에서 db 저장값을 뺀 값으로 체크 안된 버튼 반복 생성

?>
<button type="button" class="star btn btn-secondary">
  <i class="fa fa-star"></i>
</button>
<?php } ?>

</p> <br>

  <p style="text-align:left; color:black; size:18px">복지 및 급여</p>
  <p>
    <?php
  for ($i=0; $i < $health_money ; $i++) {

   ?>
    <button type="button" class="star btn btn-primary">
      <i class="fa fa-star"></i>
  </button>
<?php  }
  for ($i=0; $i < ( 5 - $health_money) ; $i++) {

?>
<button type="button" class="star btn btn-secondary">
<i class="fa fa-star"></i>
</button>
<?php } ?>

</p> <br>

<p style="text-align:left; color:black; size:18px">업무와 삶의 균형</p>
<p>
  <?php
for ($i=0; $i < $work_life ; $i++) {

 ?>
  <button type="button" class="star btn btn-primary">
    <i class="fa fa-star"></i>
</button>
<?php  }
for ($i=0; $i < ( 5 - $work_life) ; $i++) {

?>
<button type="button" class="star btn btn-secondary">
<i class="fa fa-star"></i>
</button>
<?php } ?>

</p> <br>

<p style="text-align:left; color:black; size:18px">사내문화</p>
<p>
  <?php
for ($i=0; $i < $in_company ; $i++) {

 ?>
  <button type="button" class="star btn btn-primary">
    <i class="fa fa-star"></i>
</button>
<?php  }
for ($i=0; $i < ( 5 - $in_company) ; $i++) {

?>
<button type="button" class="star btn btn-secondary">
<i class="fa fa-star"></i>
</button>
<?php } ?>

</p> <br>

<p style="text-align:left; color:black; size:18px">경영진</p>
<p>
  <?php
for ($i=0; $i < $operate ; $i++) {

 ?>
  <button type="button" class="star btn btn-primary">
    <i class="fa fa-star"></i>
</button>
<?php  }
for ($i=0; $i < ( 5 - $operate) ; $i++) {

?>
<button type="button" class="star btn btn-secondary">
<i class="fa fa-star"></i>
</button>
<?php } ?>

</p> <br>

  </div>

<!-- 메인 내용인 오른쪽 부분 -->
  <div class="main">
    <?php

if ($admin == 1) {   // 관리자가 로그인 했다면

        if ($blind == 0) {   // 블라인드 처리되지 않은 게시물이라면
        ?><form class="" action="blind_board.php" method="post">
        <input type="hidden" name="board_idx" value="<?php echo $board_idx; ?>" />
        <input type="hidden" name="user_email" value="" />
        <input type="submit" class="btn btn-warning" value="블라인드" style="float:right">
        </form>
        <?php }

          else {   // 블라인드 처리된 게시물이라면 ?>
                <form class="" action="blind_cancel_board.php" method="post">
                <input type="hidden" name="board_idx" value="<?php echo $board_idx; ?>" />
                <input type="hidden" name="user_email" value="" />
                <input type="submit" class="btn btn-primary" value="해제" style="width:80px; float:right">
                </form>
        <?php } ?>


<?php } else {  // 관리자가 아니라면

  if ($write_email == $email || empty($email)) {    // 현재 로그인한 사용자와 작성자의 이메일이 같거나 로그인하지 않은 사용자라면 신고버튼 안보이게 하기

  }
  else {  // 같지않거나 로그인되어있다면 신고 당한 기록이 있는지 조회 시키기

     $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
     // 신고당한기록이 있는지 조회
    $declare_sql = "SELECT * FROM user_declare WHERE board_num = '$board_idx'";
    $declare_result = $connect->query($declare_sql);

        if ( mysqli_num_rows($declare_result) >= 1 ) { // 만약 신고당한적이 있는 게시물이라면

        // 신고게시글중에서 신고한사람의 이메일과 현재사용자의 이메일이 같은 것을 조회 쿼리문 날리기
          $declare_sql2 = "SELECT * FROM user_declare WHERE give_user ='$email'";
          $declare_result2 = $connect->query($declare_sql2);

              $row = mysqli_fetch_assoc($declare_result2);
              $give_user_idx = $row['give_user']; // 신고한사람의 email 값
              $declare_idx = $row['idx'];

           if ($_SESSION['useremail'] == $give_user_idx) {   // 현재 로그인한 사용자의 idx 값과 신고한사람의 idx 값이 같다면 이 게시물을 이미 신고했던 유저
              ?>
              <button style="float:right" type="button" class="btn btn-danger" disabled>신고완료</button>
              <?php
           } else {  // 현재로그인한 사용자의 idx 값과 신고한 사람의 idx 값이 다르다면 이 게시물을 신고한 적이 없는 사람
               ?>
               <button style="float:right" type="button" class="btn btn-danger" data-target="#layerpop" data-toggle="modal">게시물신고</button>

               <?php

           }

        } else {    // 신고당한적이 없는 게시물이라면
          ?>
          <button style="float:right" type="button" class="btn btn-danger" data-target="#layerpop" data-toggle="modal">게시물신고</button>

          <?php

        }
      } // 로그인한 사용자와 작성자의 이메일이 같지 않다면 신고 당한 기록이 있는지 조회 하는 else 문
} // 관리자가 아닐때의 else 문

     ?>

<div class="modal fade" id="layerpop">
  <div class="modal-dialog" role="document">

<form class="singo_form" action="board_singo.php" method="post">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">신고하기</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>



     <input type="hidden" name="session_idx" value="<?php echo $email; ?>">
     <input type="hidden" name="member_idx" value="<?php echo $write_email; ?>">
     <input type="hidden" name="board_idx" value="<?php echo $board_idx; ?>">


      <div class="modal-body">
      <p>신고사유를 선택해주세요(여러개 선택가능)</p>
        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck1" value="혐오 표현이나 비속어 사용">
          <label class="custom-control-label" for="customCheck1">혐오 표현이나 비속어 사용</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck2" value="무의미한 단어, 반복적인 내용">
          <label class="custom-control-label" for="customCheck2">무의미한 단어 또는 반복적인 내용</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck3" value="다른 게시물을 도용">
          <label class="custom-control-label" for="customCheck3">다른 게시물을 도용</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck4" value="광고나 홍보성 글">
          <label class="custom-control-label" for="customCheck4">광고나 홍보성 글</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck5" value="명예훼손, 개인정보 노출">
          <label class="custom-control-label" for="customCheck5">명예훼손 또는 개인정보 노출</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="chk_singo[]" class="check custom-control-input" id="customCheck6" value="기타 권리침해 또는 기업기밀 누설">
          <label class="custom-control-label" for="customCheck6">기타 권리침해 또는 기업기밀 누설</label>
        </div>

        <div class="custom-control custom-checkbox" style="margin-bottom:7px;">
          <input type="checkbox" name="singo_input" class="custom-control-input" id="customCheck7" value="직접입력">
          <label class="custom-control-label" for="customCheck7">직접입력</label>
        </div>

        <script type="text/javascript">

        $(document).ready(function(){

        // 체크박스버튼 클릭시 이벤트 발생
        $("input:checkbox[name=singo_input]").click(function(){

            if($("input:checkbox[name=singo_input]").is(":checked") == true){ // 직접입력이 체크 되었다면
                $(".singo_textarea").attr("disabled",false);  // textarea 활성화
                $(".check").attr("disabled",true);           // 직접입력 제외 모든 체크박스 값 disabled true

            } else {
              $(".singo_textarea").attr("disabled",true);  // textarea 비활성화
              $(".check").attr("disabled",false);         // 직접입력 제외 모든 체크박스 값 disabled false
            }
        });


        });
        </script>

        <textarea class="singo_textarea" style="margin-left:25px; resize:none" name="singotextarea" rows="6" cols="35" disabled></textarea>

      </div>

      <div class="modal-footer">

        <button type="button" style="width:90px; margin-right:15px;" class="btn btn-outline-primary" data-dismiss="modal">닫기</button>
        <input type="submit" style="width:90px;" class="btn btn-outline-danger" value="신고">
      </div>

    </form>

    </div>

  </div>
</div>

   <div style="width:600px; height:150px;font-size:44px; word-break:break-all">
  <strong><?php echo $company_name; ?></strong>
   </div>



    <br><br><br>
    <p style="text-align:right; margin-right:120px; font-size:18px; margin-bottom:0;"> [ <?php echo $how_work; ?> ]</p>
   <p style="text-align:right; margin-right:120px; font-size:18px; margin-bottom:0;">근무 기간 ( <?php echo $how_long; ?> )</p>
    <p style="text-align:right; margin-right:120px; font-size:18px;">총 평점 ( <?php echo $total; ?> / 5 )</p><br><br>
    <p style="font-size:18px; font-weight:bold; color:black;">한줄평</p>
    <p style="font-size:25px; width:76%">" <?php echo nl2br($oneline); ?> "</p><br><br>
    <p style="font-size:18px; font-weight:bold; color:blue;">장점</p>
    <p style="font-size:25px; width:76%">" <?php echo nl2br($advantage); ?> "</p><br><br>
    <p style="font-size:18px; font-weight:bold; color:red;">단점</p>
    <p style="font-size:25px; width:76%">" <?php echo nl2br($dis_advantage); ?> "</p><br><br>
    <p style="font-size:18px; font-weight:bold; color:black;">경영진에 바라는 점</p>
    <p style="font-size:25px; width:76%">" <?php echo nl2br($company_required); ?> "</p><br><br>

<?php



  if ($write_email != $email) {   // 세션의 이메일과 작성자 이메일이 같지 않다면 실행
 ?>
 <br>
 <div style="margin-left:500px;">

     <button class="btn btn-primary btn-lg" type="button" name="button" onclick="history.go(-1);">이전</button>
<br><br><br>
 </div>

<?php } else {?>
  <br><br>
<div style="margin-left:400px; margin-bottom:200px;">
<a href="modify_board_view.php?idx=<?php echo $bno; ?>&title=<?php echo $oneline; ?>" class="btn btn-success btn-lg">수정</a>

<!--
<a href="delete_board_view.php?idx=<?php echo $bno; ?>" id="delete_bt" class="btn btn-warning btn-lg">삭제</a>
-->

<button id="delete" class="btn btn-warning btn-lg">삭제</button>

  <button class="btn btn-primary btn-lg" type="button" name="button" onclick="history.go(-1);">이전</button>
</div>


<?php } ?>
  </div>


</div>




<br><br><br><br><br><br><br><br>
  <!-- Footer -->
  <footer class="py-5 bg-primary">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
    </div>
  </footer>

   </body>

 </html>
