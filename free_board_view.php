<?php
  session_start();

  $bno = $_GET['idx'];

  $email = $_SESSION['useremail'];

  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

   // 조회수 증가 쿠키
  if (!empty($bno) && empty($_COOKIE['board_hit'.$bno])) {
    // 만약 $bno 가 있고 쿠키가 없다면
   $sql = "update free_board set hit = hit + 1 where idx='$bno'";
   $result = $connect->query($sql);
   if (empty($result)) {  // 쿼리문 실패했을 때
     ?>
     <script>
       alert('오류');
       history.back();
     </script>
     <?php
   }
  else {
   //setcookie('쿠키명','쿠키 값','쿠키 유지시간','경로')
   setcookie('board_hit'.$bno, TRUE, time()+(60 * 60 * 24),'/');
 }
}
///////////////////////////////////////////////

 // 게시글 불러오는 쿼리문
  $query = "SELECT * FROM free_board WHERE idx ='{$bno}'"; // idx 로 해당 게시글 찾음

  $res = mysqli_query($connect,$query);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $connect->query($query);
  if($res->num_rows >= 1) {

    $row = mysqli_fetch_array($res);
    //$board_idx = $row['idx'];
    $name = $row['name'];  // 해당글 작성자 닉네임
    $title = $row['title'];
    $content = $row['content'];
    $image = $row['image'];
    $date = $row['date'];
    $isDeleted = $row['isDeleted'];
    $hit = $row['hit'];

  }

 // 현재로그인한 사용자 정보를 불러오는 쿼리문
  $query1 = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

  $res1 = mysqli_query($connect,$query1);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res1 = $connect->query($query1);
  if($res1->num_rows >= 1) {

    $row = mysqli_fetch_array($res1);
    $login_name = $row['name'];
    $user_idx = $row['idx'];
    $email = $row['email'];
    $session_name = $row['name'];
    $admin = $row['admin'];
    $password = $row['password'];
    $verify = $row['verify'];
    $account_pause = $row['account_pause'];

  }

 // 현재 게시글의 댓글목록을 불러오는 쿼리문
  $reply_sql = "SELECT * FROM reply WHERE board_idx = '$bno' ORDER BY idx DESC";

  $reply_result = mysqli_query($connect,$reply_sql);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $reply_result = $connect->query($reply_sql);
  if($reply_result->num_rows >= 1) {   // 쿼리문 실행결과가 있을 때 실행

    $row = mysqli_fetch_array($reply_result);
    $reply_idx = $row['idx']; // 댓글의 고유 idx
    $reply_board_idx = $row['board_idx'];  // 댓글이 작성된 게시글의 idx
    $reply_user_idx = $row['user_idx'];  // 댓글 작성한 유저의 idx
    $reply_content = $row['content'];  // 댓글 내용
    $reply_date = $row['date'];  // 댓글 처음 작성 시간
    $reply_update_date = $row['update_date'];  // 댓글 수정했을때 시간

  }

/*
if ($account_pause == 1) {
  echo"
  <script>
  alert('관리자에의해 정지된 계정입니다');
  location.replace('index.php');
  </script>";
}
*/

$imageEx = explode('#',$image);
$imageCnt = count($imageEx);
$Cnt = 0;

// 수정에서 이미지를 삭제 했을 때 구분자 '#' 의 개수대로 이미지의 개수를 추출해서 #이 있다면 이미지의 개수에 포함이 되어서
// $imageEx[$i] 마다 문자열의 길이를 구해서 문자열의 길이가 0이 아닐때의 카운트를 해서 이 값을 다시 $imageCnt 에 대입
/*  현재 사용할 필요 X
for ($i=0; $i < $imageCnt ; $i++) {

   if (strlen($imageEx[$i]) >= 1) {
     $Cnt++;
   }
     echo $imageEx[$i]."<br>";
   echo $Cnt;
}
*/
//$imageCnt = $Cnt;

 ?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/free_board_view.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

  /* 게시판 read */
  #board_read {
  	width:900px;
    margin: auto;
  	position: relative;
    word-break:break-all;
 }
 #user_info {
   margin-left: 10px;
  font-size:17px;
 }
 #user_info ul li {
  float:left;
  margin-left:10px;
 }
 #list_line{
   width:880px;
   height:2px;
   background: #3498db;
   margin-top:100px;
 }

 #bo_line {
  width:880px;
  height:2px;
  background: #3498db;
  margin-top:10px;
 }
 #bo_content {
  margin-top:20px;
   width: 920px;

   font-size: 18px;
 }
 #bo_ser {

  color:#333;
  position: absolute;
  right: 0;
   margin-right: 10px;

 }

 #bo_ser > ul > li {
  float:left;
  margin-left:15px;
   font-size: 20px;
   font-style: normal;
 }

 .title{
   word-break:break-all;
   margin-left: 10px;
   width: 800px;
   height: auto;
   font-size: 30px;
   font-weight: bold;
   font-family: Tahoma;
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
<!-- 네비바 끝나는 지점 -->
<div class="jumbotron text-center">
  <h1>진실의방</h1>
  <p>서로 좋은 꿀팁은 나눕시다</p>
</div>
<br><br><br>


<div class="content">

<!-- 글 불러오기 -->
<div id="board_read" class="list_lo">
<p class="title"><?php echo $title;?></p>
<div id="user_info">
 <img class="rounded" src="image/user.png" style="width:30px;height:30px;margin-right:15px;"><font class="name"><?php echo $name; ?></font>
 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<font class="date"><?php echo $date; ?></font>&nbsp&nbsp&nbsp&nbsp
 <font class="hit">조회수 :&nbsp&nbsp<?php echo $hit;?></font>
   <div id="bo_line" style="margin-top:15px;"></div>
   <br>
 </div>

<div style="width:96%; max-height: 500px; font-size: 22px;margin-left: 10px;">


    <?php
    if (empty($image)) {  // 이미지가 없다면


    } else {

     ?>

<div class="row" style="padding-left:13px;">
 <?php
  for ($i=1; $i < $imageCnt+1 ; $i++) {
      // 이미지 출력용 for문
      if (strlen($imageEx[$i-1]) >= 1) {   // 이미지의 길이가 1보다 큰것만 출력
        //echo strlen($imageEx[$i]);
    ?>
      <div class="column" style="margin-left:10px;">
          <img src="<?php echo  "/".$imageEx[$i-1];?>" onclick="openModal();currentSlide(<?php echo $i; ?>)" width="180px;" height="150px;" class="hover-shadow" style="cursor:pointer; margin:0;">
      </div>
 <?php
     }
  }
  ?>


    <!-- The Modal/Lightbox -->
<div id="imageModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">

<?php for ($i=1; $i < $imageCnt+1 ; $i++) { ?>
    <div class="mySlides">
      <div class="numbertext" style="color:black">
        <?php echo $i." / ".($imageCnt); ?>
      </div>
          <center><img src="<?php echo  $imageEx[$i-1];?>" width="88%;" height="500px;"></center>
    </div>
      <?php } ?>

    <!-- Next/previous controls -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

 <div id="bo_line" style="width:100%;margin-bottom:5px; margin-top:5px; background:gray"></div>

    <!-- Caption text -->
    <!--
    <div class="caption-container">
      <p id="caption"></p>
    </div>
  -->

    <!-- Thumbnail image controls -->
    <div class="column">
        <?php for ($i=1; $i < $imageCnt+1 ; $i++) { ?>
      <img class="demo" src="<?php echo  $imageEx[$i-1];?>" onclick="currentSlide(<?php echo $i; ?>)" width="100px;" height="80px;" style="cursor:pointer">
    <?php } ?>
    </div>

  </div>
</div>
<!--   <img src="<?php echo  $imageEx[$i];?>" width="160px;" height="150px;" style="cursor: pointer;" onclick="doImgPop('<?php echo  $imageEx[$i];?>')"  alt="image">&nbsp&nbsp -->


  </div>


  <script>
  // Open the Modal
  function openModal() {
    document.getElementById("imageModal").style.display = "block";
  }

  // Close the Modal
  function closeModal() {
    document.getElementById("imageModal").style.display = "none";
  }

  var slideIndex = 1;
  showSlides(slideIndex);

  // Next/previous controls
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  // Thumbnail image controls
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
  }
  </script>



<?php }  // 이미지를 등록했을 때 else 문 닫히는 지점 ?>

<div style="min-height:250px; padding:5px;">
  <?php echo $content; ?>

</div>

   </div>


<div id="bo_line"></div>

<?php



  if ($session_name != $name) {   // 세션의 닉네임과 작성자 닉네임이 같지 않다면 실행
 ?>
 <br>
 <div style="float:right;">

     <button class="btn btn-primary btn-lg" type="button" name="button" onclick="history.go(-1);">이전</button>

 </div>
<br><br>
<?php }
       else {
          ?>
  <br><br>
<div style="float:right;">
<a href="free_board_modify.php?idx=<?php echo $bno; ?>&title=<?php echo $title; ?>" class="btn btn-success btn-lg">수정</a>

<!--
<a href="delete_board_view.php?idx=<?php echo $bno; ?>" id="delete_bt" class="btn btn-warning btn-lg">삭제</a>
-->
<a class="btn btn-warning btn-lg" href="delete_freeboard_view.php?idx=<?php echo $bno; ?>">삭제</a>


  <button class="btn btn-primary btn-lg" type="button" name="button" onclick="history.go(-1);">이전</button>
</div>

<br><br>

<?php } ?>

<?php
   if (isset($reply_idx) == true) { // 댓글이 달렸을 때 실행
    ?>
    <br>

<h4>댓글목록</h4>
    <div class="reply_view" style="width: 97%; margin: auto;">

         <br>
         <?php

           // 게시물에 댓글이 있다면 댓글 출력

            $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$bno."' order by idx desc";
            mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

            $reply_result = mysqli_query($connect,$reply_SQL);
            $total_reply = mysqli_num_rows($reply_result);  // 총 댓글 개수

          while ($reply_rows = mysqli_fetch_assoc($reply_result)){

            $replyIDX = $reply_rows['idx']; // 댓글의 고유 idx

            $useridx = $reply_rows['user_idx'];

            $user_SQL = "SELECT * FROM member WHERE idx='".$useridx."'";
            $user_result = mysqli_query($connect,$user_SQL);
            mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
            $user_result = $connect->query($user_SQL);

            if($user_result->num_rows >= 1) {   // 쿼리문 실행결과가 있을 때 실행

              $row = mysqli_fetch_array($user_result);
              $reply_user_name = $row['name']; // 댓글의 고유 idx 로 찾은 로그인한 유저 닉네임


            }

          ?>
         <div class="dap_lo" style="margin-bottom:15px; display:none;">
           <input id="total_reply" type="hidden" value="<?php echo $total_reply; ?>">


          <!--
          <script type="text/javascript">

           $(document).ready(function(){
             // 댓글 수정완료 버튼 눌렀을 때
             // var claked 를 다시 0 으로 만들어 주고 ajax post 방식으로 reply_modify_ok.php 로 보낸다
             $(".reply_view").on('click',"#<?php echo "reply_modify_ok".$replyIDX; ?>",function(){
              // $("#<?php echo "reply_modify_ok".$replyIDX; ?>").click(function(){  // 완료 눌렀을 때

                 clicked = '0';
                 alert(clicked,"<?php  echo "edit_btn메인".$replyIDX; ?>");


                   $.post("reply_modify_ok.php",{
                       board_idx:$(".board_idx").val(),
                       reply_idx:$("#<?php echo "hidden_btnID".$replyIDX; ?>").val(),
                       user_idx:$(".user_idx").val(),
                       reply_modify_content:$("#<?php echo "reply_modify_content".$replyIDX; ?>").val(),
                       },
                       function(data,success){
                          if(success=="success"){
                            $(".reply_view").html(data);
                            alert("댓글수정 완료");


                          }else{
                            alert("댓글수정 실패");
                         }
                        });

                      });



           });


           $(document).ready(function(){

                   //댓글 삭제버튼 눌렀을 때
                   $(".reply_view").on('click',"#<?php echo "delete_btn".$replyIDX; ?>",function(){

                    //  $("#<?php echo "delete_btn".$replyIDX; ?>").click(function(){ // 삭제버튼 눌렀을 떄

                        clicked = '0';

                          $.post("reply_delete.php",{
                              board_idx:$(".board_idx").val(),
                              reply_idx:$("#<?php echo "hidden_btnID".$replyIDX; ?>").val(),
                              user_idx:$(".user_idx").val(),
                              },
                              function(data,success){
                                 if(success=="success"){
                                   $(".reply_view").html(data);
                                   alert("댓글삭제 완료");
                                 } else {
                                   alert("댓글삭제 실패");
                                }
                               });


                        });
               });


           </script>
         -->


           <?php
           if ($reply_rows['user_idx'] == $user_idx) {  // 로그인한 사용자와 댓글 게시물유저 idx 가 같을때만 수정 삭제가 보이도록 수정
             ?>


             <div id="<?php echo "dropdown".$replyIDX; ?>" class="dropdown" style="float:right;">
             <button class="btn" type="button" data-toggle="dropdown">
               <strong><font style="font-size:23px;">=</font></strong>
                 </button>
                    <ul class="dropdown-menu dropdown-menu-right" style="background-color:#fafafa; padding:0; width:60px; height:40px;">

                       <li style="text-align:center">
                           <button id="<?php echo "edit_btn".$replyIDX; ?>" class="btn btn-sm btn-success" type="button" style="width:100%;height:100%; margin:0;">
                             수 정</button>
                       </li>


                       <li class="delete_btn_class" style="text-align:center">
                         <button id="<?php echo "delete_btn".$replyIDX; ?>" class="btn btn-sm btn-warning" type="button" name="button" style="width:100%;height:100%; margin:0;">
                           삭 제</button>
                       </li>

                        <input id="<?php echo "hidden_btnID".$replyIDX; ?>" type="hidden" value="<?php echo $replyIDX; ?>">
                  </ul>
               </div>
             <?php


           }
            ?>

           <p style="font-weight:bold; margin-bottom:3px; font-size:17px;">
             <?php
             // 댓글작성자의 닉네임과 게시글 작성자의 닉네임이 같다면 실행
             if ( $reply_user_name == $name ) {
                echo "작성자의 댓글";
             } else {
               echo $reply_user_name;
             }
              ?>
           </p>

      <!-- 댓글수정폼  -->
        <form action="reply_modify_ok.php" method="post">
          <input type="hidden" name="idx" class="board_idx" value="<?php echo $bno; ?>">
          <input type="hidden" name="title" value="<?php echo $title; ?>">
          <input type="hidden" name="reply_idx" value="<?php echo $replyIDX; ?>">

            <div id="<?php echo "edit_textarea".$replyIDX; ?>" style="display:none;">

              <div id="<?php echo "edit_or_cancel_btn".$replyIDX; ?>" style="float:right;">
                <button class="btn btn-success btn-sm" id="<?php echo "reply_modify_ok".$replyIDX; ?>" type="submit" name="button">수정완료</button>
                <button class="btn btn-warning btn-sm" id="<?php echo "reply_modify_cancel".$replyIDX; ?>" type="button" name="button">취소</button>
              </div>

              <textarea name="reply_modify_content" id="<?php echo "reply_modify_content".$replyIDX; ?>" class="reply_modify_content" rows="2" cols="35" style="resize:none"><?php echo $reply_rows['content']; ?></textarea>
            </div>
        </form>

        <script type="text/javascript">

         var clicked = '0'; // 댓글 수정버튼 눌렀을 떄 다른 댓글을 수정 못하도록 막기위한 변수
         // 자바스크립트 변수로 사용하지말고 input hidden 에다가 설정 후 받아서 사용하기 post로 주고받기 위해서

        $(document).ready(function(){
                    // 댓글 수정버튼 눌렀을 때 textarea 로 html 봐꾸기

                   $(".dap_lo").on('click',"#<?php echo "edit_btn".$replyIDX; ?>",function(){
              //     $("#<?php echo "edit_btn".$replyIDX; ?>").click(function(){ // 수정버튼 눌렀을 떄

                   //  alert(clicked);
                   //  var current_ID = $('#<?php echo "hidden_btnID".$replyIDX; ?>').val(); // 이전에 열린 TEXTAREA 의 ID
                       if (clicked > 0) {
                         alert('댓글수정을 완료해주세요');

                       } else {
                         if ($("#<?php echo "edit_textarea".$replyIDX; ?>").css('display') == 'none') {
                           $('#<?php echo "edit_textarea".$replyIDX; ?>').show();
                           $('#<?php echo "modify".$replyIDX; ?>').hide();

                           $('#<?php echo "dropdown".$replyIDX; ?>').hide();  // 드랍다운메뉴 숨김
                           $('#<?php echo "edit_or_cancel_btn".$replyIDX; ?>').show();  // 수정완료 , 취소 버튼 생성

                           clicked++;

                         }
                       }
                     });

                      // 수정 취소 버튼을 눌렀을 때 실행
                     $(".dap_lo").on('click',"#<?php echo "reply_modify_cancel".$replyIDX; ?>",function(){
                  //   $("#<?php echo "reply_modify_cancel".$replyIDX; ?>").click(function(){  // 취소 눌렀을 때

                       clicked = '0';

                       $('#<?php echo "edit_textarea".$replyIDX; ?>').hide();
                       $('#<?php echo "modify".$replyIDX; ?>').show();

                       $('#<?php echo "dropdown".$replyIDX; ?>').show();  // 드랍다운메뉴 나타냄
                       $('#<?php echo "edit_or_cancel_btn".$replyIDX; ?>').hide();  // 수정완료 , 취소 버튼 숨김

                            });

                      // 댓글삭제 버튼 클릭시 실행
                      $(".reply_view").on('click',"#<?php echo "delete_btn".$replyIDX; ?>",function() {
                         var result = confirm('댓글을 삭제하시겠습니까?');
                          if(result) {
                            //yes
                            clicked = '0';
                            location.replace('reply_delete.php?reply_idx=<?php echo $replyIDX; ?>&idx=<?php echo $bno; ?>&title=<?php echo $title; ?>');

                          }
                            else {
                            ////no
                            clicked = '0';
                             }
                           });

            });
       </script>



            <div id="<?php echo "modify".$replyIDX; ?>">

            <div style="font-weight:normal; margin-bottom:3px; font-size:17px;">
            <?php echo $reply_rows['content']; ?>

            </div>
            <p style="font-weight:normal; margin-bottom:3px; font-size:13px;">
              <?php
              if (empty($reply_rows['update_date'])) {

                 echo $reply_rows['date'];
              } else {
                 echo $reply_rows['update_date'];
              }

                ?>
            </p>

            </div>

           <hr style="width: 100%">



         </div>



<?php   } // 댓글불러오기 while 문 끝지점 ?>

<!--  댓글 더보기 기능 -->
<script type="text/javascript">

  $(function(){

   var total = $("#total_reply").val();
   var click_count = 0;
   var click_total = total/5;

    $(".dap_lo").slice(0,5).show(); // 처음보여주는 글 개수
    $(".more").click(function(e){

      click_count++;

      if (click_count >= click_total) {
        alert("마지막 댓글입니다");
        //$(".more").remove();
      }
      e.preventDefault();
      $("div.dap_lo:hidden").slice(0,5).show();  // 다음 보여줄 글 개수
      them  // 이게 없으면 한꺼번에 다 출력됨


    });
  });
</script>

        <!-- 더보기 댓글페이징 -->
          <center>
            <div id="more<?php echo $replyIDX; ?>" class="morebox" style="margin-right:30px;margin-bottom:30px;">
            <strong>
              <p class="more class="text-info"" id="<?php echo $replyIDX; ?>" style="cursor:pointer">더보기</p>
            </strong>
          </div>
        </center>
<!--  더보기 ajax 기능 실패
          <script type="text/javascript">
            $(function(){
              $('.more').on("click",function()
              {
                var ID = $(this).attr("id");

                if (ID) {

                  $.ajax({
                    type: "POST",
                    url: "ajax_more.php",
                    data: "lastmsg="+ID,
                    cache: false,
                    success: function(html){
                      $("div.reply_view").append(html);
                      $("#more"+ID).css('display') == 'none';
                    }
                  });
                }
                else {
                  $(".morebox").html('마지막');
                }
                return false;
              });
            });

          </script>
        -->
    </div>


          <?php if (isset($user_idx) == true) { // 로그인한 사용자가 있다면 실행
            ?>
            <!--- 댓글 입력 폼 -->

            <form class="" action="reply_ok.php" method="post">
           <div class="dap_ins"  style="width:100%;margin: 0 auto;">
             <input type="hidden" name="idx" class="board_idx" value="<?php echo $bno; ?>">
             <input type="hidden" name="user_idx" class="user_idx" value="<?php echo $user_idx; ?>">
             <input type="hidden" name="title" value="<?php echo $title; ?>">

             <div style="float:left; width:80%; height:100px;">
               <textarea class="reply_content" name="reply_content" placeholder="댓글을 작성해주세요." style="width:100%; height:100%;margin-left: 20px; font-size:16px; margin-right:0px; resize:none; overflow:visible; text-overflow:ellipsis" required></textarea>
             </div>
             <div style="float:left; height:100px">
               <input type="submit" class="btn-info" style="font-weight: bold;font-size:20px; width:200%;height:100%; border:0px; outline:none; float:left; color:#ffffff" value="등록">

             </div>
           </div>
         </form>
            <?php
          } else { // 로그인 하지 않았을 때 실행
            ?>
            <center>
              <br>
            <div style="width:100%;height:35%; margin: 0 auto;">
              <textarea class="reply_content" name="reply_content" placeholder="댓글을 작성하려면 로그인 해주세요." style="width: 100%; height: 100%;font-size:120%; resize:none; text-align:center; padding-top:3%;" disabled></textarea>
            </div>
          </center>
            <?php
          } ?>


    <?php
  } else {  // 댓글이 없을 때

    if (isset($user_idx) == true) {  // 로그인한 사용자가 있다면
   ?>
   <br>
   <div style="width:100%;margin: 0 auto;">
     <h4>첫 댓글을 작성해보세요</h4>

 <!--- 댓글 입력 폼 -->
 <form class="" action="reply_ok.php" method="post">

<div class="dap_ins" style="margin-bottom:30px;">
  <input type="hidden" name="idx" class="board_idx" value="<?php echo $bno; ?>">
  <input type="hidden" name="user_idx" class="user_idx" value="<?php echo $user_idx; ?>">
  <input type="hidden" name="title" value="<?php echo $title; ?>">

    <div style="float:left; width:80%; height:100px">
      <textarea class="reply_content" name="reply_content" placeholder="댓글을 작성해주세요." style="width:100%; height:100%;margin-left: 10px; font-size:16px; margin-right:0px; resize:none; overflow:visible; text-overflow:ellipsis" required></textarea>
    </div>
    <div style="float:left; height:100px">
      <input type="submit" class="btn-info" style="font-weight: bold;font-size:20px; width:200%;height:100%; border:0px; outline:none; float:left; color:#ffffff" value="등록">

    </div>
</div>
<br>
</form>
   </div>
   <?php
 } else {
   ?>
   <center>
     <br>
   <div>
     <textarea class="reply_content" name="reply_content" placeholder="댓글을 작성하려면 로그인 해주세요." rows="3" cols="65" style="margin-left: 10px; font-size:18px; margin-right:0px; resize:none; text-align:center; padding:40px 0 0 0;" disabled></textarea>
   </div>
 </center>
   <?php
 }
     ?>


     <?php
   }

 ?>

 <!--
 <script type="text/javascript">
 $(document).ready(function(){

   //////////////////////////////////////////////
   $(".reply_view").on('click',"#rep_bt",function(){

    // $("#rep_bt").click(function(){   // rep_bt 버튼을 누르면 post 방식으로 reply_ok.php 에 데이터를 보냄(댓글작성버튼)
         $.post("reply_ok.php",{
             board_idx:$(".board_idx").val(),
             user_idx:$(".user_idx").val(),
             //dat_user:$(".dat_user").val(),
             //dat_pw:$(".dat_pw").val(),
             reply_content:$(".reply_content").val(),
             },
             function(data,success){
                if(success=="success"){
                  $(".reply_view").html(data);
                  alert("댓글이 작성되었습니다");
                }else{
                  alert("댓글작성이 실패되었습니다");
               }
              });
            });

   });
 </script>
-->

</div>

<!-- 전체를 감싼 div class="content" -->
</div>
    <br><br>
      <!-- Footer -->
      <footer class="py-5 bg-primary footer" style="margin-top:100px;">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
        </div>
      </footer>


  </body>

</html>
