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
  <p>내가 작성한 글</p>
</div>
<br><br>

<center>
  <h2>내가 작성한 소통 글</h2>
  <br><br>

  <ul class="nav nav-tabs nav-justified" style="width:80%">
    <li class="nav-item">
      <a class="nav-link active" href="freeboard_post.php">소통공간 게시글</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="my_review_write_post.php">작성한 댓글</a>
    </li>
    <!--
    <li class="nav-item">
      <a class="nav-link" href="my_review_post.php">댓글 단 글</a>
    </li>
  -->
  </ul>
</center>

<br><br><br>

<div style="width:80%; margin:0 auto">

  <?php

  $page = $_GET['page'];


  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
  //$freeboard_query ="SELECT * FROM free_board order by idx desc limit 0,5"; // idx 를 기준으로 5개 내림차순정렬

  $total_query = "SELECT * FROM free_board WHERE name='".$name."'";
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨

  $result = mysqli_query($connect,$total_query);
  $total_free_article = mysqli_num_rows($result);  // 총 댓글 개수

  //echo $total_free_article;

  $view_article = 5;  // 한페이지에 몇개의 게시글 보이게 할지 결정
  if (!$page)$page=1;  // 페이지번호가 없다면 페이지 번호 1을 만듬
  $start = ($page-1) * $view_article; // 5개씩 보여줄 시작점

  $freeboard_query = "SELECT * FROM free_board WHERE name = '{$name}' order by idx desc limit $start,$view_article";

  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
  $freeboard_result = mysqli_query($connect,$freeboard_query);


    if ($total_free_article == 0) {   // 작성된 최신 소통게시글이 없을때 코드 실행
 ?>
 <div class="card">
   <div class="card-body" style="height:200px;">
     <p style="padding:60px 50px 50px 450px; font-weight:bold; font-size:30px;">작성된 게시글이 없습니다</p>
   </div>

 </div>

 <?php

} else {     // 작성된 소통 게시글이 있을때 코드 실행
   ?>

   <table class="table table-bordered" style="width: 100%; margin: auto;text-align:center;">
     <thead>
       <tr>
         <th>
            <div class="custom-control custom-checkbox">
            <input type="checkbox" class="check custom-control-input" name="chkAll" id="checkAll">
            <label class="custom-control-label" for="checkAll"></label>
          </div>
         </th>

         <th>제목</th>
        <!-- <th>작성자</th> -->
         <th>날짜</th>
         <th>조회수</th>
       </tr>
     </thead>

     <tbody>

 <!-- 데이터베이스의 컬럼들을 반복하기위한 코드 작성하기-->

 <?php

 $plus ='0';  // 반복문을 돌면서 증가하며 체크박스별로 ID 를 구분 짓기 위한 변수

 while ($rows = mysqli_fetch_assoc($freeboard_result)) {  //DB 에 저장된 데이터 수 (열 기준)

   $freeboard_idx = $rows['idx'];
   //$name = $rows['name'];
   $title = $rows['title'];
   $content = $rows['content'];
   $date = $rows['date'];
   $isDeleted = $rows['isDeleted'];
   $hit = $rows['hit'];

   $plus++;

         ?>

<td width='10'>

<form action="delete_freeboard_view.php" method="post">


  <div class="custom-control custom-checkbox">
  <input type="checkbox" name="chk_delete[]" class="check custom-control-input chk_select" id="<?php echo "customCheck".$plus; ?>" value="<?php echo $freeboard_idx; ?>">
  <label class="custom-control-label" for="<?php echo "customCheck".$plus; ?>"></label>
</div>
</td>

 <td width='250' height='15'>
<a href="free_board_view.php?idx=<?php echo $freeboard_idx; ?>&title=<?php echo $title; ?>">
  <?php

  // 게시물에 댓글이 있다면 댓글수를 출력
   $reply_SQL = "SELECT * FROM reply WHERE board_idx='".$freeboard_idx."'";
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

 <!-- <td width='120'><?php echo $name; ?></td> -->
 <td width='80'>
   <?php

       $today = date("Y-m-d");   // 오늘 날짜
       $formatdate = date("Y-m-d",strtotime($date)); //  2019-10-10 형식으로 바꿈

       echo $formatdate;


 ?>
 </td>
 <td width='80'><?php echo $hit; ?></td>
</tbody>
<?php
   }
         ?>

<!--  데이터베이스 컬럼들 반복문 끝나는 부분 -->

   </table>
<br>
   <input type="submit" name="button" class="btn btn-danger" style="width:180px; margin-left:1000px" value="체크된 글 삭제">

   <?php
}
    ?>


</form>

<script type="text/javascript">

// 전체선택 체크박스 자바스크립트문
$(document).ready(function(){
// 제일 상단의 체크박스버튼 클릭시 이벤트 발생
$("input:checkbox[name=chkAll]").click(function(){
    if($("input:checkbox[name=chkAll]").is(":checked") == true){ // 전체선택이 체크 되었다면
          $("input:checkbox[name='chk_delete[]']").prop("checked",true);           // 모든 체크박스 값 체크 활성화

    } else if($("input:checkbox[name=chkAll]").is(":checked") == false){
      $("input:checkbox[name='chk_delete[]']").prop("checked",false);         // 모든 체크박스 값 체크 활성화
    }
});
});

// 게시글의 총 개수
var all_check_count = "<?php echo $plus; ?>";  // $plus 를 가져옴으로써 마지막 개수의 숫자가 저장되기 때문에 총 개수로 사용하기 위한 변수선언

$(document).on("click",".chk_select", function(){
  // 전체선택 체크박스를 사용하지 않고 모은 체크박스를 선택했을때 전체선택 체크박스도 체크하기
  if (all_check_count == $("input:checkbox[name='chk_delete[]']:checked").length) {
       $("#checkAll").prop('checked',true);
  } else { // 모든 체크박스가 선택되어있지 않다면 전체선택 체크박스 비활성화
      $("#checkAll").prop('checked',false);
  }


});

</script>

<br><br>




<br><br><br>

    <?php

    if ($total_free_article != 0) {   // 작성된 게시물의 수 0 아니면

     ?>

    <ul class="pagination pagination-lg justify-content-center">

    <?php    // ceil()  올림함수
    //ceil($total_article / $view_article); // 몇개의 페이지가 필요한지 구하기 위함
    $total_page = ceil($total_free_article / $view_article);
    //echo $total_free_article;
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
