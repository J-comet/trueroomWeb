<?php
  session_start();

  $email = $_SESSION['useremail'];


  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

  $res = mysqli_query($connect,$query);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $connect->query($query);
  if($res->num_rows >= 1) {       // 쿼리에 맞는 결과 값이 있다면 그에 맞는 값을 가져옴

    $row = mysqli_fetch_array($res);
    $email = $row['email'];
    $name = $row['name'];
    $admin = $row['admin'];
    $password = $row['password'];
    $gender = $row['gender'];
    $favorite_place = $row['favorite_place'];
    $favorite_job = $row['favorite_job'];
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
      input[type='radio']{
        display: none;
        margin: 10px;
      }
      input[type='radio']+ label:hover{
        background-color: #87ceeb;
        cursor: pointer;
      }
      input[type='radio'] + label{
        display: inline-block;
        border-radius: 5px;
        margin: 2px;
        padding: 8px;
        background-color: white;
        border: 1px solid skyblue;
        font-size: 15px;
        width: 130px;
        text-align: center;
      }

      input[type='radio']:checked + label{

        background-color: #4b89dc;
        color: #fff;
        font-weight: bold;

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
  <p>비밀번호는 항상 안전하게 관리하기</p>
</div>
<br><br><br>

  <div style="width:55%; margin:0 auto;">
    <h2>마이페이지</h2>
    <br><br><br>
  <ul class="nav nav-tabs nav-justified">
    <li class="nav-item">
      <a class="nav-link" href="mypage.php">내정보수정</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="password_page.php">비밀번호변경</a>
    </li>
    <!--
    <li class="nav-item">
      <a class="nav-link" href="verify_page.php"> 인증 </a>
    </li>
  -->
  </ul>

  <hr style="margin:0">

    <div><br>
    <!--  <center><h3>비밀번호변경</h3></center>  -->

      <div class="card-body">
      <form method="post" action="password_modify.php" name="memform" class="signup-form">

      <br>
             <table style="margin:0 auto;">
               <tr style="margin-bottom:7px;">


                 <tr>
                   <td>기존 비밀번호</td>
                 </tr>
                 <tr>
                   <td><input style="margin:5px 0 10px 0;" class="pwcheck" id="password" type="password" size="35" name="beforepw" onkeyup="password1();" placeholder="비밀번호" required>&nbsp&nbsp</td>


                 <tr>
                   <td>새 비밀번호</td>
                 </tr>
                 <tr>
                   <td><input style="margin:5px 0 10px 0;" class="pwcheck" id="password" type="password" size="35" name="newpw" onkeyup="password1();" placeholder="비밀번호" required>&nbsp&nbsp</td>

                 </tr>
                 <tr>
                   <td>비밀번호 확인</td>
                 </tr>
                 <tr>
                   <td><input style="margin:5px 0 10px 0;" id="passwordCheck" type="password" size="35" name="pw_check" onkeyup="passwordCheckFunction();" placeholder="비밀번호 확인" required>&nbsp&nbsp</td>

                 </tr>

             </table>
             <br>
       <center>
      <input class="btn btn-outline-primary" style="width:320px; height:50px; margin:0 auto" type="submit" value="변경하기"/>
    </center>
      </form>
      </div>
      </div>


    <div id="verify" class="container tab-pane fade"><br><br>
      <center><h3>인증</h3></center>

    </div>

</div>


    <br><br>
      <!-- Footer -->
      <footer class="py-5 bg-primary">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
        </div>
      </footer>


  </body>

</html>
