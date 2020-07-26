<?php
  session_start();

$page = $_GET['page'];
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

  }

if ($admin != 1) {
?>
<script>
  alert('잘못된접근입니다');
  location.replace("index.php");
</script>

<?php } ?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>진실의방</title>
<style media="screen">
  #gnb:hover{cursor: pointer;}
  #sub{
    margin-left: 600px;
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
  #div_menu{

    height: 100%;
    float: left;
    background-color: #e9e9e9;
    text-align: left;
  }
  #div_con{
    width: 80%;
    height: 100%;
    margin-left: 30px;
    float: left;
  /*  background: skyblue; */

  }
  #div_bottom{
    width: 100%;
    height: 130px;
    clear: both;
    margin: 0;
    text-align: center;
  }
  .sidebar-nav{
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
  }

.sidebar-nav li{
  text-indent: 1.5em;
  line-height: 2.8em;
}

.sidebar-nav li a {
  display: block;
  text-decoration: none;
  color: black;
}

.sidebar-nav li a:hover{
  color: #fff;
  font-weight: bold;
  background: gray;
}

  .sidebar-brand{
font-size: 1.3em;
line-height: 3em;
  }

  .paging_div{
    display: none;
    visibility: hidden;
  }
  .allBtn:hover{
    background: black;
  }
  .fewBtn:hover{
    background: black;
  }
  .dat_delete {
  	font-size: 14px;
  	display: none;

  }
</style>


  </head>
  <body style="padding:0; margin:0;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="height:100px;">
      <a class="navbar-brand" href="#" style="margin-left:750px;margin-right:150px;">진실의방 관리자페이지</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

    </nav>
<!-- 네비바 끝나는 지점 -->


<div style="margin:0; height:980px; width:100%">
  <div id="div_menu">

   <ul class="sidebar-nav">
     <li class="sidebar-brand">
       <br>
       <p style="padding-left:20px; font-size:25px;">관리자메뉴</p>
     </li>

     <li><a href="true_admin.php" style="padding-left:40px;">회원관리</a></li>

     <li><a href="true_board_admin.php" style="padding-left:40px;">기업리뷰신고관리</a></li>

      <li><a href="true_admin_question.php" style="padding-left:40px;">문의사항관리</a></li>

     <li><a href="index.php" style="padding-left:40px;">홈으로</a></li>

   </ul>

  </div>
  <div id="div_con" class="user_table">
    <br><br><br><br>
<center><h2>유저목록</h2></center>
<br><br><br>

<script type="text/javascript">

$(document).ready(function(){


    $("#allBtn").click(function(){   // allBtn 버튼을 누르면 post 방식으로 all_user.php 에 데이터를 보냄
        $.post("all_user.php",{
            five:$(".five").val(),
            },
            function(data,success){
               if(success=="success"){
                 $(".table").html(data);
                 //$(".table").removeClass(".table-bordered");
                // alert("데이터 5개씩 정렬");
               }else{
                 alert("실패");
              }
             });
           });

           });
</script>



<?php



$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결
$query = "SELECT * FROM member WHERE admin != '1'";    // member 의 모든 데이터를 조회
$result = mysqli_query($connect,$query);
$total_user = mysqli_num_rows($result);
//$total_user = $total_user - 1;

//일반유저
$query = "SELECT * FROM member WHERE admin != '1' AND verify = '0'";    // 일반회원의 모든 데이터를 조회
$result = mysqli_query($connect,$query);
$total_basic_user = mysqli_num_rows($result);


$view_user = 5;  // 한페이지에 몇개 보이게 할지 결정


if (!$page)$page=1;  // 페이지번호가 없다면 페이지 번호 1을 만듬
$start = ($page-1) * $view_user; // 5개씩 보여줄 시작점

 ?>


<span style="margin-left:150px; font-size:20px;">총 회원수 :&nbsp&nbsp <?php echo $total_user;?> 명 </span>

<span style="margin-left:150px; font-size:20px;">일반 회원수 :&nbsp&nbsp <?php echo $total_basic_user;?> 명 </span>

<span style="margin-left:150px; font-size:20px;">인증한 회원수 :&nbsp&nbsp <?php echo $total_user - $total_basic_user;?> 명 </span>

<br><br><br>

<ul class="nav nav-pills">
 <li class="nav-item">
   <a class="nav-link active" href="#">모든회원</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="true_admin_basic.php">일반회원</a>
 </li>
 <li class="nav-item">
   <a class="nav-link" href="true_admin_work.php">인증회원</a>
 </li>

</ul>

<br><br>
  <table class="table table-bordered" style="text-align:center; margin-top:20px; margin:0; padding:0;">
    <thead>
      <tr>
        <th>이메일</th>
        <th>닉네임</th>
        <th>성별</th>
        <th>작성게시글수</th>
        <th>블라인드게시글수</th>
        <th>블라인드목록</th>
        <th>가입날짜</th>
        <th>계정정지</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $query1 ="SELECT * FROM member order by idx desc limit $start,$view_user"; // idx 를 기준으로 내림차순정렬
      mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐
      $result = mysqli_query($connect,$query1);

      while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)
        $uidx = $rows['idx'];  // member 테이블의 idx 값
        $useremail = $rows['email'];
        $username = $rows['name'];
        $gender = $rows['gender'];
        $date = $rows['date'];
        $account_pause = $rows['account_pause'];
        $admin = $rows['admin'];
        $verify = $rows['verify'];

        // reviewinfo 의 member_idx 와 member 의 idx 가 같고 블라인드처리된 게시글을 조회
        $blind_count_query = "SELECT * FROM reviewinfo WHERE member_idx ='$uidx' AND isDeleted ='1'";
        $blind_result = mysqli_query($connect,$blind_count_query);

        if (isset($blind_result)) {  // 값이 존재한다면

              $total_blind = mysqli_num_rows($blind_result);

        } else {
          $total_blind = 0;
        }

        if ($admin != 1) {
          $sql = "SELECT * FROM reviewinfo WHERE member_idx = {$uidx}";
          $resul = mysqli_query($connect,$sql);
          $user_article = mysqli_num_rows($resul);
     ?>
    <tr>
      <td style="vertical-align:middle">
        <?php
        if ($verify == 0) {
          echo $useremail."<br>";
          echo "<font color='#0096c6';>[일반회원]</font>";
        } else {
          echo $useremail."<br>";
          echo "<font color='#00bf00'>[인증회원]</font>";
        }
         ?>
      </td>
      <td style="vertical-align:middle"><?php echo $username; ?></td>
      <td style="vertical-align:middle"><?php echo $gender; ?></td>
      <td style="vertical-align:middle"><?php echo $user_article; ?></td>
      <td style="vertical-align:middle"><?php echo $total_blind; ?></td>
      <td style="vertical-align:middle">

        <!-- The Modal -->
        <div class="modal fade" id="<?php echo "mymodal".$uidx; ?>">
        <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
         <h4 class="modal-title"><?php echo $useremail." 님 블라인드 목록"; ?></h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">

          <table class="table" style="table-layout:fixed">
            <thead>
              <tr>
                <th>기업명</th>
                <th>한줄평</th>
                <th>게시물이동</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $modal_query = "SELECT * FROM reviewinfo WHERE isDeleted ='1' ORDER BY idx DESC";
              mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐
              $modal_result = mysqli_query($connect,$modal_query);

              while ($modal_rows = mysqli_fetch_assoc($modal_result)) {  //DB 에 저장된 데이터 수 (열 기준)
                 $modal_company_name = $modal_rows['company_name'];
                 $modal_oneline = $modal_rows['oneline'];
                 $modal_idx = $modal_rows['idx'];
                 $modal_memberidx = $modal_rows['member_idx'];

                 if ($modal_memberidx == $uidx) {
                   ?>
              <tr>
                <td width:"50px" style="text-overflow:ellipsis; overflow:hidden"><nobr><?php echo $modal_company_name; ?></nobr></td>
                <td width:"200px" style="text-overflow:ellipsis; overflow:hidden" title="<?php echo $modal_oneline; ?>"><nobr><?php echo $modal_oneline; ?></nobr></td>
                <td width:"70px" style="text-overflow:ellipsis; overflow:hidden"><a href="board_view.php?idx=<?php echo $modal_idx; ?>">바로가기</a></td>
              </tr>
            <?php } } ?>
            </tbody>
          </table>

        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
        </div>
        </div>
        <?php
               if ($total_blind == 0) {
              ?>
              <button type="button" class="btn btn-success" disabled>없음</button>
              <?php
            } else {
              ?>
             <button type="button" class="btn btn-success" data-target="#<?php echo "mymodal".$uidx; ?>" data-toggle="modal">목록</button>
              <?php
            }
                 ?>
     </td>
      <td style="vertical-align:middle"><?php echo $date; ?></td>

      <td style="vertical-align:middle"><?php if ($account_pause != 1) {
      ?><form class="" action="pause_user.php" method="post">
      <input type="hidden" name="user_idx" value="<?php echo $uidx; ?>" />
      <input type="hidden" name="user_email" value="<?php echo $useremail; ?>" />
      <input type="submit" class="btn btn-warning btn-sm" value="계정정지">
      </form>
      <?php
    } else {
      ?>
      <form class="" action="cancel_pause_user.php" method="post">
      <input type="hidden" name="user_idx" value="<?php echo $uidx; ?>" />
      <input type="hidden" name="user_email" value="<?php echo $useremail; ?>" />
      <input type="submit" class="btn btn-primary btn-sm" value="정지해제">
      </form>
      <?php
    } ?></td>
    </tr>
  <?php }
} ?>
  </tbody>
</table>




  <br><br><br>

<?php


$total_page = ceil($total_user / $view_user);

//echo $total_user."<br>";
//echo $view_user."<br>";
//echo $total_page."<br>";


 ?>

  <ul id="admin_paging" class="pagination pagination-lg justify-content-center">
   <?php

   //echo "pagingNum<br>".$paging_num;
   //echo "total<br>".$total;
   //echo "total_page<br>".$total_page;

   if ($page %5) {   // 5로 나누었을 때 나머지가 있다면 ( 5로 나누어 떨어지지 않는다면 )
   $start_page = $page - ($page % 5) + 1;

   //echo "start_page".$start_page;
   //echo "if".$page;
   //echo "<br>value".$page%5;
   } else {              // 나누어 떨어진다면
   $start_page = $page - 4;
   //echo "else".$start_page;
   //echo "else".$page;
  // echo "start".$start_page;
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

   <script type="text/javascript">

   $(document).ready(function(){



              $("#allBtn").click(function(){
                    $("#admin_paging").css("display",'none');

                     });

              $("#fewBtn").click(function(){
                  location.reload();

                     });

           /*

           $("#allBtn").click(function(){
               $.post("admin_paging.php",{
                   five:$(".five").val(),
                   total_user:$(".total_user").val(),
                   },
                   function(data,success){
                      if(success=="success"){
                        $("#admin_paging").css("display",'none');
                        // alert('paging');
                      }else{
                        alert("실패");
                     }
                    });
                  });



              $("#fewBtn").click(function(){
                  $.post("admin_paging.php",{
                      five:$(".five").val(),
                      total_user:$(".total_user").val(),
                      },
                      function(data,success){
                         if(success=="success"){
                           $("#admin_paging").css({
                             "display" : 'inline',
                             "height" : '50px',
                             "width" : '150px'
                           });


                      //     var s = document.getElementByld("#admin_paging");
                      //     s.style.removeProperty("display");
                          //  alert('pa');
                         }else{
                           alert("실패");
                        }
                       });
                     });
               */

              });
   </script>

  </div>



<!--
<div id="div_bottom" class="bg-primary">
    <p class="text-center text-white" style="padding:25px;">Copyright &copy; (주)진실의방 2019</p>
</div>
-->


</div>




  </body>

</html>
