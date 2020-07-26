<?php
  session_start();

  $email = $_SESSION['useremail'];


  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query = "SELECT * FROM member WHERE email ='{$email}'"; // 로그인한 email 로 member 에서 해당 email의 정보를 찾음

  $res = mysqli_query($connect,$query);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $connect->query($query);
  if($res->num_rows >= 1) {

    $row = mysqli_fetch_array($res);

    $session_idx = $row['idx'];
    $login_name = $row['name'];
    $admin = $row['admin'];
    $favorite_place = $row['favorite_place'];  // 일반회원의 선호 지역
    $favorite_job = $row['favorite_job'];   // 일반회원의 선호 직업

    $my_company = $row['company_name']; // 인증한 회원의 기업이름

    $verify = $row['verify'];

    $account_pause = $row['account_pause'];

  }

 ?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" media="screen and (min-width:900px)" href="widescreen.css">
    <link rel="stylesheet" media="screen and (min-width:600px)" href="smallscreen.css">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>진실의방</title>

    <style media="screen">

    #gnb:hover{cursor: pointer;}
    #sub{
      /*margin-left: 400px;*/
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
    .table thead th{
      text-align: center;

    }
    .table tbody tr td{

      /* 게시판 내용의 위치 정하는 곳  */
    }

    .titleline{

      font-size:19px;
       overflow: hidden;
      text-overflow: ellipsis;
       display: -webkit-box;
       -webkit-line-clamp:2;
       -webkit-box-orient:vertical;
       word-wrap: break-word;
       height: 60px;
    }

    .date{
      text-align: right;
      margin: 0;
      padding-right: 3px;
      font-size: 15px;
    }

    .infoline{
      width:85%;
      margin-top:15px;
      font-size: 13px;
      color: gray;
    }


    .fa{
       color:yellow;

    }

    .star{
      padding-left: 8px;
      padding-top: 4px;
      width: 33px;
      height: 33px;
      margin: 0;

    }

    .star:hover{
      cursor: not-allowed;

    }
    </style>

  </head>

<?php


if ($account_pause == 1) {   // 계정이 정지당했다면 팝업창 실행
  ?>
  <script>

  function change(form) {  // 셀렉트값이 바뀔 때
      if (form.url.selectedIndex !=0)
          parent.location = form.url.options[form.url.selectedIndex].value
      }

  function setCookie( name, value, expiredays ){
      var todayDate = new Date();
          todayDate.setDate( todayDate.getDate() + expiredays );
          document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
  }

  function getCookie( name ){
      var nameOfCookie = name + "=";
      var x = 0;
          while ( x <= document.cookie.length ) {
              var y = (x+nameOfCookie.length);
                  if ( document.cookie.substring( x, y ) == nameOfCookie ) {
                  if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                      endOfCookie = document.cookie.length;
                  return unescape( document.cookie.substring( y, endOfCookie ) );
              }
          x = document.cookie.indexOf( " ", x ) + 1;
          if ( x == 0 )
          break;
      }
      return "";
  }

      if ( getCookie( "Notice" ) != "done" ) {  // 쿠키의 값이 done 이 아니라면 계속 생성함
      noticeWindow  =  window.open('notice.html','경고','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=400,height=445,top=200,left=300');
      noticeWindow.opener = self;
  }
  </script>
  <?php
}


?>

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
                  <p style="float:right; color:white;margin-right:2px; margin-left:5px;"><strong><?php echo "$login_name"; ?></strong> 님</p>

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
                     <a id="gnb" class="nav-link" style="marin-right:50px;"><img class="rounded" src="image/user.png" style="width:30px;height:30px;margin-right:15px;"><?php echo "$login_name 님"; ?>
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

<div class="jumbotron text-center">
  <h1>진실의방</h1>
  <p>진실된 기업리뷰로 모든 구직자 살리자!</p>
</div> <br><br><br>

<div style="width:90%; margin:0 auto" >

<h3 class="text-center">최근기업리뷰</h3>
<hr align="center" style="width:90%">
<br>

<div class="row" style="padding:15px;">


<?php
$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
$query ="SELECT * FROM reviewinfo WHERE isDeleted = '0' order by idx desc limit 4"; // idx 를 기준으로 내림차순정렬
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$result = mysqli_query($connect,$query);

while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)

  $idx = $rows['idx'];
  $company_name = $rows['company_name']; //기업명
  $what_job = $rows['what_job'];  // 업종
  $where_work = $rows['where_work']; // 근무지역
  $how_work = $rows['how_work'];  // 정규직인지?
  $date = $rows['date']; //작성일
  $username = $rows['name']; // 작성자
  $usergender = $rows['gender']; // 성별
  $company_money = $rows['company_money']; // 연봉
  $total = $rows['total']; //총평점
  $oneline = $rows['oneline']; // 한줄평
  //$useremail = $rows['email'];
  //$blind = $rows['isDeleted']; // 블라인드 처리 값


?>
<div style="width:21.3%; margin-left: 3%; height:35%;">
 <!--<div class="col-lg-3 col-xs-6 mb-4">-->
 <p class="date">
<?php
$today = date("Y-m-d");   // 오늘 날짜
$formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈

if ($today == $formatdate) {

$formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
 echo $formatdate;
}
else {
 echo $formatdate;
} ?>
</p>
 <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
   <div class="card">

     <div class="card-body" style="height:320px; padding:17px 22px 22px 22px;">
       <div style="margin:0 0 15px 6px; font-weight:bold; height: 23px;width:200px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap"><?php echo $company_name; ?></div>
       <p class="titleline card-title text-primary"><?php echo $oneline; ?><p>
       <p class="infoline"><?php echo $what_job; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $how_work; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $where_work; ?></p>
<p style="margin-top: 3;"> 만족도 <?php echo $total; ?> / 5</p>
       <p>
         <?php
       for ($i=0; $i < round($total) ; $i++) {    // db 저장값을 불러와 저장값 만큼 체크된 버튼 반복해서 생성

        ?>
         <button type="button" class="star btn btn-primary">
           <i class="fa fa-star"></i>
       </button>
       <?php  }
       for ($i=0; $i < ( 5 - round($total)) ; $i++) {   // 총 별의 개수에서 db 저장값을 뺀 값으로 체크 안된 버튼 반복 생성

       ?>
       <button type="button" class="star btn btn-secondary">
       <i class="fa fa-star"></i>
       </button>
       <?php } ?>

       </p>

       <bottom><a class="btn btn-primary btn-block" style="color:white" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>"><strong>바로가기</strong></a></bottom>
     </div>
   </div>
 </div>


<?php } ?>


  <!-- 기업리뷰 div class=row 끝지점 -->
</div>
<br><br><br>
<?php

   if (empty($email)) {
     // 로그인 안한 사용자는 관심지역 안보여줌
    ?>

    <h3 class="text-center">최근 소통공간 게시글</h3>
    <!--  <hr align="center" style="width:90%"> -->
    <br>

    <div style="width:80%; margin:0 auto;">

      <?php
      $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
      $freeboard_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬
      mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
      $freeboard_result = mysqli_query($connect,$freeboard_query);

      $total_free_article = mysqli_num_rows($freeboard_result); // 해당 쿼리 결과값의 총 개수

        if ($total_free_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
     ?>
     <div class="card">
       <div class="card-body" style="height:200px;">
         <p style="padding:60px 50px 50px 450px; font-weight:bold; font-size:30px;">작성된 게시글이 없습니다</p>
       </div>

     </div>

     <?php

   } else {     // 작성된 최신소통 게시글이 있을때 코드 실행
       ?>

       <table class="table" style="text-align:center">
         <thead>
           <tr>
       <!--  <th>번호</th>  -->
             <th>제목</th>
             <th>작성자</th>
             <th>날짜</th>
             <th>조회수</th>
           </tr>
         </thead>

         <tbody>

     <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->


     <?php


     while ($rows = mysqli_fetch_assoc($freeboard_result)) {  //DB 에 저장된 데이터 수 (열 기준)

       $idx = $rows['idx'];
       $write_name = $rows['name'];
       $title = $rows['title'];
       $content = $rows['content'];
       $date = $rows['date'];
       $isDeleted = $rows['isDeleted'];
       $hit = $rows['hit'];


             ?>
<!--  <td width='90'><?php echo $cnt; ?></td>  -->

     <td width='250'>

    <a href="free_board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $title; ?>">
      <?php

      // 게시물에 댓글이 있다면 댓글수를 출력
       $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$idx."'";
       mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

       $reply_result = mysqli_query($connect,$reply_SQL);
       $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

       if ($total_reply < 1) {  //  댓글이 달려있지 않다면 제목만 출력
          echo $title;
       } else {
         echo $title;?> <font class="text-info">&nbsp[<?php echo $total_reply; ?>]</font>

       <?php }  ?>
    </a>
     </td>
     <td width='120'><?php echo $write_name; ?></td>
     <td width='80'>
       <?php

           $today = date("Y-m-d");   // 오늘 날짜
           $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈
         if ($today == $formatdate) {

           $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
             echo $formatdate;
         }
         else {
             echo $formatdate;
         }

     ?>
     </td>
     <td width='80'><?php echo $hit; ?></td>
</tbody>
   <?php
       }
             ?>

  <!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

       </table>
       <?php
  }
        ?>
         </div>

    <?php


  } else { // 로그인 한 사용자

   if ($admin==1) {  // 로그인한 사용자가 관리자 일때 실행
     ?>

     <h3 class="text-center">최근 소통공간 게시글</h3>
     <!--  <hr align="center" style="width:90%"> -->
     <br>

     <div style="width:80%; margin:0 auto">

       <?php
       $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
       $freeboard_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬
       mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
       $freeboard_result = mysqli_query($connect,$freeboard_query);

       $total_free_article = mysqli_num_rows($freeboard_result); // 해당 쿼리 결과값의 총 개수

         if ($total_free_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
      ?>
      <div class="card">
        <div class="card-body" style="width:100%;height:15%; text-align:center">
          <p style="padding: 2% 0 2% 0; font-weight:bold; font-size:25px;">작성된 게시글이 없습니다</p>
        </div>
      </div>

      <?php

    } else {     // 작성된 최신소통 게시글이 있을때 코드 실행
        ?>

        <table class="table" style="text-align:center">
          <thead>
            <tr>
        <!--  <th>번호</th>  -->
              <th>제목</th>
              <th>작성자</th>
              <th>날짜</th>
              <th>조회수</th>
            </tr>
          </thead>

          <tbody>

      <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->


      <?php


      while ($rows = mysqli_fetch_assoc($freeboard_result)) {  //DB 에 저장된 데이터 수 (열 기준)

        $idx = $rows['idx'];
        $name = $rows['name'];
        $title = $rows['title'];
        $content = $rows['content'];
        $date = $rows['date'];
        $isDeleted = $rows['isDeleted'];
        $hit = $rows['hit'];


              ?>
 <!--  <td width='90'><?php echo $cnt; ?></td>  -->

      <td width='250'>

     <a href="free_board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $title; ?>">
       <?php

       // 게시물에 댓글이 있다면 댓글수를 출력
        $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$idx."'";
        mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

        $reply_result = mysqli_query($connect,$reply_SQL);
        $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

        if ($total_reply < 1) {  //  댓글이 달려있지 않다면 제목만 출력
           echo $title;
        } else {
          echo $title;?> <font class="text-info">&nbsp[<?php echo $total_reply; ?>]</font>

        <?php }  ?>
     </a>
      </td>
      <td width='120'><?php echo $name; ?></td>
      <td width='80'>
        <?php

            $today = date("Y-m-d");   // 오늘 날짜
            $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈
          if ($today == $formatdate) {

            $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
              echo $formatdate;
          }
          else {
              echo $formatdate;
          }

      ?>
      </td>
      <td width='80'><?php echo $hit; ?></td>
 </tbody>
    <?php
        }
              ?>

   <!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

        </table>
        <?php
   }
         ?>
          </div>

          <?php
   }


 //  일반회원일때 [최신기업리뷰] + [관심지역기업리뷰] + [관심직종기업리뷰] + [소통공간 최신글]
    else if ($verify == 0) {
     ?>
     <h3 class="text-center">관심지역에 대한 최근기업리뷰</h3>
     <hr align="center" style="width:90%">
     <br>

     <div class="row" style="padding:15px;">


     <?php
     $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
     $query ="SELECT * FROM reviewinfo WHERE isDeleted = '0' AND where_work = '$favorite_place' order by idx desc limit 4"; // idx 를 기준으로 내림차순정렬
     mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
     $result = mysqli_query($connect,$query);

     $total_article = mysqli_num_rows($result); // 해당 쿼리 결과값의 총 개수


     if ($total_article == 0) {
       ?>

       <div style="width:21.3%; margin-left: 3%; height:55%;">

        <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
          <div class="card">

                <div class="card-body" style="width:100%; height:100%;">
                  <p style="margin: 27% 0 27% 16.5%;font-weight:bold; font-size:100%;">작성된 게시글이 없습니다</p>
                </div>

            </div>
          </div>

       <?php
      }

     while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)

       $idx = $rows['idx'];
       $company_name = $rows['company_name']; //기업명
       $what_job = $rows['what_job'];  // 업종
       $where_work = $rows['where_work']; // 근무지역
       $how_work = $rows['how_work'];  // 정규직인지?
       $date = $rows['date']; //작성일
       $username = $rows['name']; // 작성자
       $usergender = $rows['gender']; // 성별
       $company_money = $rows['company_money']; // 연봉
       $total = $rows['total']; //총평점
       $oneline = $rows['oneline']; // 한줄평
       //$useremail = $rows['email'];
       //$blind = $rows['isDeleted']; // 블라인드 처리 값

     ?>

     <div style="width:21.3%; margin-left: 3%; height:35%;">

  <!--   <div style="width:300px; margin-left: 30px; height:350px;"> -->
      <!--<div class="col-lg-3 col-xs-6 mb-4">-->
      <p class="date">
     <?php
     $today = date("Y-m-d");   // 오늘 날짜
     $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈

     if ($today == $formatdate) {

     $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
      echo $formatdate;
     }
     else {
      echo $formatdate;
     } ?>
     </p>
      <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
        <div class="card">

          <div class="card-body" style="height:320px; padding:17px 22px 22px 22px;">
            <div style="margin:0 0 15px 6px; font-weight:bold; height: 23px;width:200px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap"><?php echo $company_name; ?></div>
            <p class="titleline card-title text-primary"><?php echo $oneline; ?><p>
            <p class="infoline"><?php echo $what_job; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $how_work; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $where_work; ?></p>
     <p style="margin-top: 3;"> 만족도 <?php echo $total; ?> / 5</p>
            <p>
              <?php
            for ($i=0; $i < round($total) ; $i++) {    // db 저장값을 불러와 저장값 만큼 체크된 버튼 반복해서 생성

             ?>
              <button type="button" class="star btn btn-primary">
                <i class="fa fa-star"></i>
            </button>
            <?php  }
            for ($i=0; $i < ( 5 - round($total)) ; $i++) {   // 총 별의 개수에서 db 저장값을 뺀 값으로 체크 안된 버튼 반복 생성

            ?>
            <button type="button" class="star btn btn-secondary">
            <i class="fa fa-star"></i>
            </button>
            <?php } ?>

            </p>

            <bottom><a class="btn btn-primary btn-block" style="color:white" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>"><strong>바로가기</strong></a></bottom>
          </div>
        </div>
      </div>


     <?php } ?>


       <!-- 관심지역 div class=row 끝지점 -->
     </div>


     <br><br><br>

     <h3 class="text-center">관심직종에 대한 최근기업리뷰</h3>
     <hr align="center" style="width:90%">
     <br>

     <div class="row" style="padding:15px;">


     <?php
     $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
     $query ="SELECT * FROM reviewinfo WHERE isDeleted = '0' AND what_job = '$favorite_job' order by idx desc limit 4"; // idx 를 기준으로 내림차순정렬
     mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
     $result = mysqli_query($connect,$query);

     $total_article = mysqli_num_rows($result); // 해당 쿼리 결과값의 총 개수

     if ($total_article == 0) {
       ?>

       <div style="width:21.3%; margin-left: 3%; height:55%;">

        <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
          <div class="card">

                <div class="card-body" style="width:100%; height:100%;">
                  <p style="margin: 27% 0 27% 16.5%;font-weight:bold; font-size:100%;">작성된 게시글이 없습니다</p>
                </div>

            </div>
          </div>


       <?php
     }


     while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)

       $idx = $rows['idx'];
       $company_name = $rows['company_name']; //기업명
       $what_job = $rows['what_job'];  // 업종
       $where_work = $rows['where_work']; // 근무지역
       $how_work = $rows['how_work'];  // 정규직인지?
       $date = $rows['date']; //작성일
       $username = $rows['name']; // 작성자
       $usergender = $rows['gender']; // 성별
       $company_money = $rows['company_money']; // 연봉
       $total = $rows['total']; //총평점
       $oneline = $rows['oneline']; // 한줄평
       //$useremail = $rows['email'];
       //$blind = $rows['isDeleted']; // 블라인드 처리 값


     ?>

     <div style="width:21.3%; margin-left: 3%; height:35%;">
      <!--<div class="col-lg-3 col-xs-6 mb-4">-->
      <p class="date">
     <?php
     $today = date("Y-m-d");   // 오늘 날짜
     $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈

     if ($today == $formatdate) {

     $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
      echo $formatdate;
     }
     else {
      echo $formatdate;
     } ?>
     </p>
      <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
        <div class="card">

          <div class="card-body" style="height:320px; padding:17px 22px 22px 22px;">
            <div style="margin:0 0 15px 6px; font-weight:bold; height: 23px;width:200px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap"><?php echo $company_name; ?></div>
            <p class="titleline card-title text-primary"><?php echo $oneline; ?><p>
            <p class="infoline"><?php echo $what_job; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $how_work; ?>&nbsp&nbsp/&nbsp&nbsp<?php echo $where_work; ?></p>
     <p style="margin-top: 3;"> 만족도 <?php echo $total; ?> / 5</p>
            <p>
              <?php
            for ($i=0; $i < round($total) ; $i++) {    // db 저장값을 불러와 저장값 만큼 체크된 버튼 반복해서 생성

             ?>
              <button type="button" class="star btn btn-primary">
                <i class="fa fa-star"></i>
            </button>
            <?php  }
            for ($i=0; $i < ( 5 - round($total)) ; $i++) {   // 총 별의 개수에서 db 저장값을 뺀 값으로 체크 안된 버튼 반복 생성

            ?>
            <button type="button" class="star btn btn-secondary">
            <i class="fa fa-star"></i>
            </button>
            <?php } ?>

            </p>

            <bottom><a class="btn btn-primary btn-block" style="color:white" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>"><strong>바로가기</strong></a></bottom>
          </div>
        </div>
      </div>


     <?php } ?>


       <!-- 기업리뷰 div class=row 끝지점 -->
     </div>
<br><br><br>


     <h3 class="text-center">최근 소통공간 게시글</h3>
     <!--  <hr align="center" style="width:90%"> -->
     <br>
     <div style="width:80%; margin:0 auto">

       <?php
       $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
       $freeboard_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬
       mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
       $freeboard_result = mysqli_query($connect,$freeboard_query);

       $total_free_article = mysqli_num_rows($freeboard_result); // 해당 쿼리 결과값의 총 개수

         if ($total_free_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
      ?>

      <div class="card">
        <div class="card-body" style="width:100%;height:15%; text-align:center">
          <p style="padding: 2% 0 2% 0; font-weight:bold; font-size:25px;">작성된 게시글이 없습니다</p>
        </div>
      </div>

      <?php

    } else {     // 작성된 최신소통 게시글이 있을때 코드 실행
        ?>

        <table class="table" style="text-align:center">
          <thead>
            <tr>
        <!--  <th>번호</th>  -->
              <th>제목</th>
              <th>작성자</th>
              <th>날짜</th>
              <th>조회수</th>
            </tr>
          </thead>

          <tbody>

      <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->


      <?php


      while ($rows = mysqli_fetch_assoc($freeboard_result)) {  //DB 에 저장된 데이터 수 (열 기준)

        $idx = $rows['idx'];
        $name = $rows['name'];
        $title = $rows['title'];
        $content = $rows['content'];
        $date = $rows['date'];
        $isDeleted = $rows['isDeleted'];
        $hit = $rows['hit'];


              ?>
<!--  <td width='90'><?php echo $cnt; ?></td>  -->

      <td width='250'>

     <a href="free_board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $title; ?>">
       <?php

       // 게시물에 댓글이 있다면 댓글수를 출력
        $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$idx."'";
        mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

        $reply_result = mysqli_query($connect,$reply_SQL);
        $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

        if ($total_reply < 1) {  //  댓글이 달려있지 않다면 제목만 출력
           echo $title;
        } else {
          echo $title;?> <font class="text-info">&nbsp[<?php echo $total_reply; ?>]</font>

        <?php }  ?>
     </a>
      </td>
      <td width='120'><?php echo $name; ?></td>
      <td width='80'>
        <?php

            $today = date("Y-m-d");   // 오늘 날짜
            $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈
          if ($today == $formatdate) {

            $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
              echo $formatdate;
          }
          else {
              echo $formatdate;
          }

      ?>
      </td>
      <td width='80'><?php echo $hit; ?></td>
</tbody>
    <?php
        }
              ?>

   <!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

        </table>
        <?php
   }
         ?>
          </div>

     <?php

   }  //  일반회원일때 [최신기업리뷰] + [관심지역기업리뷰] + [관심직종기업리뷰] + [소통공간 최신글] 끝나는 지점

    ///////////////////////////////////////////
    ///////////////////////////////////////////

    // 기업회원 일때 [최신기업리뷰] + [소통공감글 최신글] + [소통공감글 제목과내용에 내 기업이 있는 글] 을 보여주기 //
     else {
       ////////////////////////////////////////
   // 최신 소통글 + 소통공감글의 제목이나 내용에 본인의 기업명이 있는 글을 보여주는 위치
   ?>

   <h3 class="text-center">최근 소통공간 게시글</h3>
   <!--  <hr align="center" style="width:90%"> -->
   <br>
   <div style="width:80%; margin:0 auto">

     <?php
     $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
     $freeboard_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬
     mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
     $freeboard_result = mysqli_query($connect,$freeboard_query);

     $total_free_article = mysqli_num_rows($freeboard_result); // 해당 쿼리 결과값의 총 개수

       if ($total_free_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
    ?>
    <div class="card">
      <div class="card-body" style="width:100%;height:15%; text-align:center">
        <p style="padding: 2% 0 2% 0; font-weight:bold; font-size:25px;">작성된 게시글이 없습니다</p>
      </div>
    </div>

    <?php

  } else {     // 작성된 최신소통 게시글이 있을때 코드 실행
      ?>

      <table class="table" style="text-align:center">
        <thead>
          <tr>
      <!--  <th>번호</th>  -->
            <th>제목</th>
            <th>작성자</th>
            <th>날짜</th>
            <th>조회수</th>
          </tr>
        </thead>

        <tbody>

    <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->


    <?php


    while ($rows = mysqli_fetch_assoc($freeboard_result)) {  //DB 에 저장된 데이터 수 (열 기준)

      $idx = $rows['idx'];
      $name = $rows['name'];
      $title = $rows['title'];
      $content = $rows['content'];
      $date = $rows['date'];
      $isDeleted = $rows['isDeleted'];
      $hit = $rows['hit'];


            ?>
<!--  <td width='90'><?php echo $cnt; ?></td>  -->

    <td width='250'>

   <a href="free_board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $title; ?>">
     <?php

     // 게시물에 댓글이 있다면 댓글수를 출력
      $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$idx."'";
      mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

      $reply_result = mysqli_query($connect,$reply_SQL);
      $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

      if ($total_reply < 1) {  //  댓글이 달려있지 않다면 제목만 출력
         echo $title;
      } else {
        echo $title;?> <font class="text-info">&nbsp[<?php echo $total_reply; ?>]</font>

      <?php }  ?>
   </a>
    </td>
    <td width='120'><?php echo $name; ?></td>
    <td width='80'>
      <?php

          $today = date("Y-m-d");   // 오늘 날짜
          $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈
        if ($today == $formatdate) {

          $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
            echo $formatdate;
        }
        else {
            echo $formatdate;
        }

    ?>
    </td>
    <td width='80'><?php echo $hit; ?></td>
</tbody>
  <?php
      }
            ?>

 <!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

      </table>
      <?php
 }
       ?>
        </div>

<br><br>


<h3 class="text-center">내 기업에 대한 최근 소통공간 게시글</h3>


<!--  <hr align="center" style="width:90%"> -->
<br>
<div style="width:80%; margin:0 auto">

  <?php
  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
  //$myCompany_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬
  //$myCompany_query ="SELECT * FROM free_board WHERE (title LIKE '$my_company' OR content LIKE '$my_company') AND isDeleted = '0' order by idx desc limit 5"; // idx 를 기준으로 내림차순정렬
  //$myCompany_query ="SELECT * FROM free_board WHERE title LIKE '%$my_company%' OR content = '%$my_company%' order by idx desc limit 4"; // idx 를 기준으로 내림차순정렬
  $myCompany_query ="SELECT * FROM free_board WHERE (title LIKE '%$my_company%' AND isDeleted = '0') OR (content LIKE '%$my_company%' AND isDeleted = '0') order by idx desc limit 4"; // idx 를 기준으로 내림차순정렬


  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $myCompany_result = mysqli_query($connect,$myCompany_query);

  $total_myCompany_article = mysqli_num_rows($myCompany_result); // 해당 쿼리 결과값의 총 개수

    if ($total_myCompany_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
 ?>
 <div class="card">
   <div class="card-body" style="width:100%;height:15%; text-align:center">
     <p style="padding: 2% 0 2% 0; font-weight:bold; font-size:25px;">작성된 게시글이 없습니다</p>
   </div>
 </div>

 <?php

} else {     // 작성된 최신소통 게시글이 있을때 코드 실행
   ?>

   <table class="table" style="text-align:center">
     <thead>
       <tr>
   <!--  <th>번호</th>  -->
         <th>제목</th>
         <th>작성자</th>
         <th>날짜</th>
         <th>조회수</th>
       </tr>
     </thead>

     <tbody>

 <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->


 <?php


 while ($rows = mysqli_fetch_assoc($myCompany_result)) {  //DB 에 저장된 데이터 수 (열 기준)

   $idx = $rows['idx'];
   $name = $rows['name'];
   $title = $rows['title'];
   $content = $rows['content'];
   $date = $rows['date'];
   $isDeleted = $rows['isDeleted'];
   $hit = $rows['hit'];


         ?>
<!--  <td width='90'><?php echo $cnt; ?></td>  -->

 <td width='250'>

<a href="free_board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $title; ?>">
  <?php

  // 게시물에 댓글이 있다면 댓글수를 출력
   $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$idx."'";
   mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

   $reply_result = mysqli_query($connect,$reply_SQL);
   $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

   if ($total_reply < 1) {  //  댓글이 달려있지 않다면 제목만 출력
      echo $title;
   } else {
     echo $title;?> <font class="text-info">&nbsp[<?php echo $total_reply; ?>]</font>

   <?php }  ?>
</a>
 </td>
 <td width='120'><?php echo $name; ?></td>
 <td width='80'>
   <?php

       $today = date("Y-m-d");   // 오늘 날짜
       $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈
     if ($today == $formatdate) {

       $formatdate = date(" G : i ",strtotime($date)); //  13 : 10 형식으로 바꿈
         echo $formatdate;
     }
     else {
         echo $formatdate;
     }

 ?>
 </td>
 <td width='80'><?php echo $hit; ?></td>
</tbody>
<?php
   }
         ?>

<!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

   </table>
   <?php
}
    ?>
     </div>

      <?php
    }
  }
    ?>


<br><br>





<!-- container  끝나는 지점 -->
</div>

    <br><br>
      <!-- Footer -->
      <footer class="py-5 bg-primary">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
        </div>
        <!-- /.container -->
      </footer>


  </body>

</html>
