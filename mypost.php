<?php
  session_start();

  $session_email = $_SESSION['useremail'];

  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query = "SELECT * FROM member WHERE email ='{$session_email}'"; // email 로 해당 email 찾음

  $res = mysqli_query($connect,$query);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $connect->query($query);
  if($res->num_rows >= 1) {

    $row = mysqli_fetch_array($res);
    $email = $row['email'];
    $name = $row['name'];
    $admin = $row['admin'];
    $password = $row['password'];
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
    <link rel="stylesheet" href="/css/mypost.css">
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
  <p>항상 당신의 기업리뷰에 감사드립니다</p>
</div> <br><br><br>

<center>
  <h2>내가 작성한 기업리뷰</h2>
  <hr style="width:80%">
</center>

<br><br>

<div style="margin: 0 auto;width:90%;">

  <div class="row">


  <?php

  $page = $_GET['page'];

  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결

  $query = "SELECT * FROM reviewinfo WHERE email like '%{$session_email}%'";
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $result = mysqli_query($connect,$query);
  $total_article = mysqli_num_rows($result);
    // 총 게시물 개수


  $view_article = 8;  // 한페이지에 몇개의 게시글 보이게 할지 결정
  if (!$page)$page=1;  // 페이지번호가 없다면 페이지 번호 1을 만듬
  $start = ($page-1) * $view_article; // 5개씩 보여줄 시작점


  // 실제 주소데이터 가져오기
  $query1 ="SELECT * FROM reviewinfo WHERE email like '%{$session_email}%' order by idx desc limit $start,$view_article"; // idx 를 기준으로 내림차순정렬
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $result = mysqli_query($connect,$query1);

  if ($total_article==0) {   // 작성된 게시물의 수 0 이라면
    ?>
    <div style="width:290px; margin-left: 50px; height:350px; margin-top: 22px; margin-bottom:70px;">

       <div class="card" style="background:#fff">

         <div class="card-body" style="height:360px; padding:17px 22px 22px 22px; vertical-align: middle;">
           <p style="text-align: center; font-weight:bold; margin-top:140px; font-size:20px;"><?php echo "기업리뷰를 작성해주세요"; ?></p>

         </div>
       </div>

     </div>
    <?

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
    $blind = $rows['isDeleted']; // 블라인드 처리 값
    //$useremail = $rows['email'];
   ?>



<?php
   if ($blind == 1 ) {  // 블라인드처리된 게시물이라면
?>
<div style="width:290px; margin-left: 50px; height:350px; margin-top: 22px; margin-bottom:70px;">

   <div class="card" style="background:#e2e2e2">

     <div class="card-body" style="height:360px; padding:17px 22px 22px 22px; vertical-align: middle;">
       <p style="text-align: center; font-weight:bold; margin-top:120px; font-size:20px;"><?php echo "관리자에의해 블라인드<br>처리된 게시물입니다"; ?></p>

     </div>
   </div>

 </div>

<?php
   } else { ?>

     <div style="width:290px; margin-left: 50px; height:350px; margin-bottom:70px;">
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

          <div class="card-body" style="height:360px; padding:17px 22px 22px 22px;">
            <p style="margin:0 0 20px 10px; font-weight:bold;"><?php echo $company_name; ?></p>
            <p class="titleline card-title text-primary"><?php echo $oneline; ?><p>
            <p class="infoline"><?php echo $what_job; ?> / <?php echo $how_work; ?> / <?php echo $where_work; ?></p>
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

            <script>
            $(document).ready(function(){

                $('#delete').click(function() {
                   var result = confirm('삭제하시겠습니까?');
                    if(result) {
                      //yes
                      location.replace('delete_mypage_view.php?idx=<?php echo $idx; ?>');
                    }
                      else {
                      ////no
                       }
                     });
            });
            </script>

            <bottom><a class="btn btn-primary btn-block" style="color:white; margin-bottom:10px;" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>"><strong>바로가기</strong></a></bottom>
            <bottom><button id="delete" class="btn btn-warning btn-block" style="color:white"><strong>삭제하기</strong></button></bottom>
          </div>
        </div>

      </div>

     <?php } ?>

  <?php } // while 문 닫히는 지점 ?>

    <!-- body div class=row 끝지점 -->
  </div>

</div>

<?php

if ($total_article != 0) {   // 작성된 게시물의 수 0 아니면

 ?>

<ul class="pagination pagination-lg justify-content-center">

<?php    // ceil()  올림함수
//ceil($total_article / $view_article); // 몇개의 페이지가 필요한지 구하기 위함
$total_page = ceil($total_article / $view_article);
//echo $total_page;
// echo "전체페이징 그룹:".$total_page = ceil($total_article / $view_article);
//echo "<br>";

//$total_page 변수에 전체페이지 그룹의 개수를 저장


//페이지 인덱스의 시작과 종료 범위 구하기
// 5페이지를 하나의 그룹으로 지정

if ($page %5) {   // 5로 나누었을 때 나머지가 있다면 ( 5로 나누어 떨어지지 않는다면 )
$start_page = $page - ($page % 5) + 1;
//echo "if".$start_page;
//echo "if".$page;
//echo "<br>value".$page%5;
} else {              // 나누어 떨어진다면
$start_page = $page - 4;
//echo "else".$start_page;
//echo "else".$page;
}

$end_page = $start_page + 5;

// 페이지 그룹이동 //

// 1. 이전 그룹 //
$prev_group = $start_page -1;
if ($prev_group < 1) {
$prev_group=1;
}

// 2. 다음 그룹 //
$next_group = $end_page;
if ($next_group > $total_page) {
$next_group=$total_page;
}

// 처음페이지로 이동 //
if ($page != 1) {
echo "<li class='page-item'><a class='page-link' href=$PHP_SELF?page=1><<</a></li>";
} else {
echo "<li class='page-item disabled'><a class='page-link'><<</a></li>";
}

// 1. 이전 페이지 그룹이동버튼 //
if ($page != 1) {
  echo "<li class='page-item'><a class='page-link' href = $PHP_SELF?page=$prev_group>이전</a></li>";
} /* else {
  echo "<li class='page-item disabled'><a class='page-link'>이전</a></li>";
}
*/


// 페이지번호 생성 //
for($i=$start_page; $i < $end_page; $i++){

  if ($i > $total_page)break;  // 전체게시글의 나머지 이후에 번호를 생성하는것 막음

  if($i==$page){  //현재 출력된 게시글과 페이지 개수가 같다면
    echo "<li class='page-item active'><a class='page-link'>$i</a></li>";
  }
     else{
       echo "<li class='page-item'><a class='page-link' href=$PHP_SELF?page=$i>$i</a></li>";
     }
}


// 2. 다음 페이지 그룹 이동버튼 //
/*
if ($page != $total_page) {
  echo "<li class='page-item'><a class='page-link' href=$PHP_SELF?page=$next_group>다음</a></li>";
}
*/

if ($page <=($total_page + $page - $end_page)) {
  echo "<li class='page-item'><a class='page-link' href=$PHP_SELF?page=$next_group>다음</a></li>";
}


// 마지막페이지로 이동 //
if ($page < $total_page) {
  echo "<li class='page-item'><a class='page-link' href=$PHP_SELF?page=$total_page>>></a></li>";
} else {
  echo "<li class='page-item disabled'><a class='page-link'>>></a></li>";
}

 ?>

</ul>
<?php } ?>


    <br><br>
      <!-- Footer -->
      <footer class="py-5 bg-primary">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
        </div>
      </footer>


  </body>

</html>
