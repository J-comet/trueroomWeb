<?php
  session_start();

  $email = $_SESSION['useremail'];


  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

  $res = mysqli_query($connect,$query);
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $res = $connect->query($query);
  if($res->num_rows >= 1) {

    $row = mysqli_fetch_array($res);

    $name = $row['name'];
    $gender = $row['gender']; // 성별
    $admin = $row['admin'];  // 관리자인지 확인
    $verify = $row['verify'];  // 인증된 유저인지 확인
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
    <link rel="stylesheet" href="/css/review_board.css">
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
  <p>취준생, 직딩, 퇴사자 모두 응원합니다</p>
</div> <br><br><br>

<h1 class="text-center">모든 기업리뷰</h1><br><br>

<div style="width:75%; margin:0 auto; height:auto;">
  <center>
    <form action="search_review_result.php" method="get">

      <div style="width:80%; height:40px; border:0px solid skyblue; float:left; margin-right:2px">

        <select name="category" style="float:left;">
          <option value="company_name">기업명</option>
          <option value="name">닉네임</option>
          <option value="what_job">직종</option>
          <option value="where_work">근무지역</option>
        </select>

       <div style="margin-left: 5px;width: 80%; height: auto;float:left; border:1px solid skyblue;">
         <input type="text" name="search" placeholder="검색어 입력" style="float:left;font-size:16px; width:355px; height: 36.5px;padding:8px 0 4px 10px; border:0px; outline:none;" required>
         <button class="btn-primary" type="submit" style="font-size:15px; width:70px; height:37.5px; border:0px; outline:none; float:right; color:#ffffff">검색</button>

       </div>
      </div>
      </form>
    </center>


<br><br><br><br>


<?php


$page = $_GET['page'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
$query = "select * from reviewinfo";    // reviewinfo 의 모든 데이터를 조회
$result = mysqli_query($connect,$query);
$total_article = mysqli_num_rows($result);  // 총 게시물 개수

$view_article = 5;  // 한페이지에 몇개의 게시글 보이게 할지 결정
if (!$page)$page=1;  // 페이지번호가 없다면 페이지 번호 1을 만듬
$start = ($page-1) * $view_article; // 5개씩 보여줄 시작점


// 실제 주소데이터 가져오기
$query1 ="SELECT * FROM reviewinfo order by idx desc limit $start,$view_article"; // idx 를 기준으로 내림차순정렬
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$result = mysqli_query($connect,$query1);


  while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)

    $idx = $rows['idx'];
    $company_name = $rows['company_name']; //기업명
    $what_job = $rows['what_job'];  // 업종
    $where_work = $rows['where_work']; // 근무지역
    $date = $rows['date']; //작성일
    $username = $rows['name']; // 작성자
    $usergender = $rows['gender']; // 성별
    $company_money = $rows['company_money']; // 연봉
    $total = $rows['total']; //총평점
    $oneline = $rows['oneline']; // 한줄평
    //$useremail = $rows['email'];
    $blind = $rows['isDeleted'];


   if ($blind == 1 ) {   //블라인드 처리된 게시물이라면

     if ($admin == 1) {   // 관리자인지 확인 관리자라면 블라인드 처리되었지만 게시글에 들어갈 수 있음
?>
<a class="card_adr" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>">
<div class="card" style="border: 2px solid skyblue;">

<div class="date">
  <center><p style="text-align:center; color:white; margin-top:35px;" class="btn btn-warning btn-lg">블라인드 처리된 게시물 보기</p></center>
</div>
<div class="post">

<div class="postleft">

</div>

<div class="postcenter">

</div>

<div class="postright">

</div>

</div>
</div>
</a>

<?php
} else {    // 블라인드 처리된 게시물이고 관리자가 아닐 때
?>
<a class="card_adr" href="blind_post.php">
<div class="card" style="border: 2px solid skyblue; background:skyblue">

<div class="post">

<div class="postleft">
  <!--
 <p style="font-size:21px; color:black;"><?php echo $company_name; ?></p>
 <p style="margin:0; font-size:14px;"><?php echo $what_job; ?> | <?php echo $where_work; ?> | <?php echo $usergender; ?></p>
-->
</div>

<div class="postcenter">
<p>관리자에의해 블라인드 처리된 게시물입니다</p>
</div>

<div class="postright">
  <!--
<p style="margin-bottom: 10px; font-size:18px;">만족도&nbsp&nbsp&nbsp<?php echo $total; ?>  / 5</p>
<p style="margin:0; font-size:18px;">연봉&nbsp&nbsp&nbsp<?php echo $company_money; ?> 만원</p>
-->
</div>

</div>
</div>
</a>
<?php
    }
     ?>



     <?php
   } else {  // 블라인드 처리된 게시물이 아니라면
     ?>

     <a class="card_adr" href="board_view.php?idx=<?php echo $idx; ?>&title=<?php echo $oneline; ?>">
     <div class="card" style="border: 2px solid skyblue;">

     <div class="date">
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
        &nbsp&nbsp|&nbsp&nbsp <?php echo $username; ?>
     </div>
     <div class="post">

     <div class="postleft">
    <!--   <p style="font-size:21px; color:black; height:3%; overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $company_name; ?></p>
            -->
      <p style="font-size:150%; color:black; height:3%; overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $company_name; ?></p>
      <p style="margin:0; font-size:80%;"><?php echo $what_job; ?> | <?php echo $where_work; ?> | <?php echo $usergender; ?></p>
     </div>

     <div class="postcenter">
     <?php  echo $oneline;?>
     </div>

     <div class="postright">
     <p style="margin-bottom: 4%; font-size:120%;">만족도&nbsp&nbsp&nbsp<?php echo $total; ?>  / 5</p>
     <p style="margin:0; font-size:120%;">연봉&nbsp&nbsp&nbsp<?php echo $company_money; ?> 만원</p>

     </div>

     </div>
     </div>
     </a>

     <?php
   }
 ?>

<br><br>
<?php } ?>



<div style="float:right">
  <?php
   // 로그인은 했지만 기업회원인지 추가적으로 검사

      if (isset($email)) {   // 로그인했는지

           if ($verify == 1) {  //기업회원인지
             ?>
             <a href="write_review_board.php">
             <button type="button" class="btn btn-primary btn-lg">글작성</button>
             </a>
             <?php
           } else {
             ?>
             <button type="button" class="btn btn-primary btn-lg" onclick="alert('일반회원 작성불가능')">글작성</button>
          <?php
           }

      } else {
        ?>
        <a href="check_login.php">
        <button type="button" class="btn btn-primary btn-lg">글작성</button>
        </a>
        <?php
      }
        ?>



</div>
<br><br><br>

<!-- body 시작할때 감싸는 부분 끝지점 -->


<ul class="pagination pagination-lg justify-content-center">

<?php    // ceil()  올림함수
//ceil($total_article / $view_article); // 몇개의 페이지가 필요한지 구하기 위함
$total_page = ceil($total_article / $view_article);
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
