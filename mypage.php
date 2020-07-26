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
    $company_name = $row['company_name'];
    $what_service = $row['what_service'];
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
  <p>바뀐 내 정보들 수정하세요</p>
</div>
<br><br><br>

<div style="margin:0 auto; width:55%">
  <h2>마이페이지</h2>
  <br><br><br>

  <ul class="nav nav-tabs nav-justified">
    <li class="nav-item">
      <a class="nav-link active" href="mypage.php">내정보수정</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="password_page.php">비밀번호변경</a>
    </li>

    <!--
    <li class="nav-item">
      <a class="nav-link" href="verify_page.php"> 인증 </a>
    </li>
  -->
  </ul>
  <hr style="margin:0">

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="myinfo"><br>
    <!--  <center><h3>내정보수정</h3></center>  -->

     <div class="card-body">

       <?php
         if ($verify == 0) {
          ?>
        <form method="post" action="mypage_basic_modify.php" name="memform" class="signup-form">
          <?php
         } else {
           ?>
           <form method="post" action="mypage_workman_modify.php" name="memform" class="signup-form">
           <?php
         }
        ?>


    <br>
             <table style="margin:0 auto;">
               <tr style="margin-bottom:7px;">
                 <td>이메일</td>
                 </tr>
                 <tr>
                 <td>
                   <input type="text" size="35" name="useremail" id="useremail" class="check" value="<?php echo $email; ?>"  style="margin:5px 0 10px 0; color:gray" readonly /></td>
                 </td>
               </tr>
               <tr>
                 <td>닉네임</td>
               </tr>
               <tr>
                 <td><input maxlength="6" style="margin:5px 0 10px 0;" id="username" class="check_name" type="text" size="35" name="username" value="<?php echo $name; ?>" required></td>
               </tr>

               <tr>
                 <td>성별</td>
               </tr>
               <tr>
                 <td>   <input type="radio" id="gender1" name="gender" value="남자" <?php if($gender=="남자"):?> checked <?php endif ?>><label for="gender1">남자</label>
                   <input type="radio" id="gender2" name="gender" value="여자"<?php if($gender=="여자"):?> checked <?php endif ?>><label for="gender2">여자</label>
                 </td>

               </tr>

<?php

    if ($verify == 0) {  // 일반회원이라면
      ?>
      <tr>
        <td>
          <div style="margin-top:10px;">
          관심지역
          </div>
          </td>
      </tr>
      <tr>
        <td>
          <select name="favorite_place" style="width:345px; height:38px;" required>

            <option value="">관심지역</option>
            <option value="서울" <?php if($favorite_place=="서울"):?> selected <?php endif ?>>&nbsp&nbsp서울</option>
            <option value="경기" <?php if($favorite_place=="경기"):?> selected <?php endif ?>>&nbsp&nbsp경기</option>
            <option value="인천" <?php if($favorite_place=="인천"):?> selected <?php endif ?>>&nbsp&nbsp인천</option>
            <option value="부산" <?php if($favorite_place=="부산"):?> selected <?php endif ?>>&nbsp&nbsp부산</option>
            <option value="대구" <?php if($favorite_place=="대구"):?> selected <?php endif ?>>&nbsp&nbsp대구</option>
            <option value="대전" <?php if($favorite_place=="대전"):?> selected <?php endif ?>>&nbsp&nbsp대전</option>
            <option value="광주" <?php if($favorite_place=="광주"):?> selected <?php endif ?>>&nbsp&nbsp광주</option>
            <option value="울산" <?php if($favorite_place=="울산"):?> selected <?php endif ?>>&nbsp&nbsp울산</option>
            <option value="세종" <?php if($favorite_place=="세종"):?> selected <?php endif ?>>&nbsp&nbsp세종</option>
            <option value="강원" <?php if($favorite_place=="강원"):?> selected <?php endif ?>>&nbsp&nbsp강원</option>
            <option value="경남" <?php if($favorite_place=="경남"):?> selected <?php endif ?>>&nbsp&nbsp경남</option>
            <option value="경북" <?php if($favorite_place=="경북"):?> selected <?php endif ?>>&nbsp&nbsp경북</option>
            <option value="전남" <?php if($favorite_place=="전남"):?> selected <?php endif ?>>&nbsp&nbsp전남</option>
            <option value="전북" <?php if($favorite_place=="전북"):?> selected <?php endif ?>>&nbsp&nbsp전북</option>
            <option value="충남" <?php if($favorite_place=="충남"):?> selected <?php endif ?>>&nbsp&nbsp충남</option>
            <option value="충북" <?php if($favorite_place=="충북"):?> selected <?php endif ?>>&nbsp&nbsp충북</option>
            <option value="제주" <?php if($favorite_place=="제주"):?> selected <?php endif ?>>&nbsp&nbsp제주</option>
            <option value="해외" <?php if($favorite_place=="해외"):?> selected <?php endif ?>>&nbsp&nbsp해외</option>
            <option value="기타" <?php if($favorite_place=="기타"):?> selected <?php endif ?>>&nbsp&nbsp기타</option>

            </optgroup>
             </select>
        </td>
      </tr>

      <tr>
        <td>
          <div style="margin-top:10px;">
          관심직종
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <select name="favorite_job" style="width:345px; height:38px;" required>

            <option value="">관심직종</option>
            <option value="IT/인터넷" <?php if($favorite_job=="IT/인터넷"):?> selected <?php endif ?> >&nbsp&nbspIT/인터넷</option>
            <option value="경영/기획/컨설팅" <?php if($favorite_job=="경영/기획/컨설팅"):?> selected <?php endif ?>>&nbsp&nbsp경영/기획/컨설팅</option>
            <option value="교육" <?php if($favorite_job=="교육"):?> selected <?php endif ?>>&nbsp&nbsp교육</option>
            <option value="금융/재무" <?php if($favorite_job=="금융/재무"):?> selected <?php endif ?>>&nbsp&nbsp금융/재무</option>
            <option value="디자인" <?php if($favorite_job=="디자인"):?> selected <?php endif ?>>&nbsp&nbsp디자인</option>
            <option value="마케팅/시장조사" <?php if($favorite_job=="마케팅/시장조사"):?> selected <?php endif ?>>&nbsp&nbsp마케팅/시장조사</option>
            <option value="미디어/홍보" <?php if($favorite_job=="미디어/홍보"):?> selected <?php endif ?>>&nbsp&nbsp미디어/홍보</option>
            <option value="법률/법무" <?php if($favorite_job=="법률/법무"):?> selected <?php endif ?>>&nbsp&nbsp법률/법무</option>
            <option value="생산/제조" <?php if($favorite_job=="생산/제조"):?> selected <?php endif ?>>&nbsp&nbsp생산/제조</option>
            <option value="생산관리/품질관리" <?php if($favorite_job=="생산관리/품질관리"):?> selected <?php endif ?>>&nbsp&nbsp생산관리/품질관리</option>
            <option value="서비스/고객지원" <?php if($favorite_job=="서비스/고객지원"):?> selected <?php endif ?>>&nbsp&nbsp서비스/고객지원</option>
            <option value="엔지니어링" <?php if($favorite_job=="엔지니어링"):?> selected <?php endif ?>>&nbsp&nbsp엔지니어링</option>
            <option value="연구개발" <?php if($favorite_job=="연구개발"):?> selected <?php endif ?>>&nbsp&nbsp연구개발</option>
            <option value="영업/제휴" <?php if($favorite_job=="영업/제휴"):?> selected <?php endif ?>>&nbsp&nbsp영업/제휴</option>
            <option value="유통/무역" <?php if($favorite_job=="유통/무역"):?> selected <?php endif ?>>&nbsp&nbsp유통/무역</option>
            <option value="의약" <?php if($favorite_job=="의약"):?> selected <?php endif ?>>&nbsp&nbsp의약</option>
            <option value="인사/총무" <?php if($favorite_job=="인사/총무"):?> selected <?php endif ?>>&nbsp&nbsp인사/총무</option>
            <option value="전문직" <?php if($favorite_job=="전문직"):?> selected <?php endif ?>>&nbsp&nbsp전문직</option>
            <option value="특수계층/공공" <?php if($favorite_job=="특수계층/공공"):?> selected <?php endif ?>>&nbsp&nbsp특수계층/공공</option>

            </optgroup>

             </select>
        </td>
      </tr>
      <?php
    } else {
      ?>
      <tr style="margin-bottom:7px;">
        <td>
          <div style="margin-top:10px;">
          기업명
          </div>
          </td>
        </tr>
        <tr>
        <td>
          <input type="text" size="35" maxlength="40" name="usercompany" value="<?php echo $company_name; ?>"  style="margin:5px 0 10px 0;" /></td>
        </td>
      </tr>

      <tr>
        <td>
          <div style="margin-top:10px;">
          산업군
        </div></td>
      </tr>
      <tr>
        <td>
          <div>
            <select name="what_service" style="width:350px;height:38px;" required>

              <option value="">산업군 선택</option>
              <option value="서비스업" <?php if($what_service=="서비스업"):?> selected <?php endif ?> >서비스업</option>
              <option value="제조/화학" <?php if($what_service=="제조/화학"):?> selected <?php endif ?> >제조/화학</option>
              <option value="의료/제약/복지" <?php if($what_service=="의료/제약/복지"):?> selected <?php endif ?> >의료/제약/복지</option>
              <option value="유통/무역/운송" <?php if($what_service=="유통/무역/운송"):?> selected <?php endif ?>>유통/무역/운송</option>
              <option value="교육업" <?php if($what_service=="교육업"):?> selected <?php endif ?>>교육업</option>
              <option value="건설업" <?php if($what_service=="건설업"):?> selected <?php endif ?>>건설업</option>
              <option value="IT/웹/통신" <?php if($what_service=="IT/웹/통신"):?> selected <?php endif ?>>IT/웹/통신</option>
              <option value="미디어/디자인" <?php if($what_service=="미디어/디자인"):?> selected <?php endif ?>>미디어/디자인</option>
              <option value="은행/금융업" <?php if($what_service=="은행/금융업"):?> selected <?php endif ?>>은행/금융업</option>
              <option value="기관/협회" <?php if($what_service=="기관/협회"):?> selected <?php endif ?>>기관/협회</option>


              </optgroup>
               </select>
          </div>

        </td>
      </tr>
      <?php
    }
 ?>



             </table>
             <br><br><br>

<center>
     <input class="btn btn-outline-primary" style="width:150px; height:50px; margin:0 auto" type="submit" value="수정하기"/>
     <input class="btn btn-outline-primary" style="width:150px; height:50px; margin:0 auto" type="reset" value="되돌리기"/>
</center>
     </form>
     </div>

    </div>

<!--
    <div id="verify" class="container tab-pane fade"><br><br>
      <center><h3>인증</h3></center>

    </div>
  -->
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
