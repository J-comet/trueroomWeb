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


<div style="margin:0; height:1200px; width:100%">
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
<center><h2>신고 목록</h2></center>
<br><br><br>


<?php

$page = $_GET['page'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("connect fail");   // db 연결

$query = "SELECT * FROM user_declare";
$result = mysqli_query($connect,$query);
$total_article = mysqli_num_rows($result);   // 신고목록의 총 개수

$view_article = 5;  // 한페이지에 몇개 보이게 할지 결정

if (!$page)$page=1;  // 페이지번호가 없다면 페이지 번호 1을 만듬
$start = ($page-1) * $view_article; // 5개씩 보여줄 시작점

?>

<table class="table table-bordered" style="width: 100%;text-align:center; margin-top:20px; margin:0; padding:0;">
  <thead>
    <tr>
      <th width="12%">신고자</th>
      <th width="18%">신고사유</th>
      <th width="12%">게시글작성자</th>
      <th width="10%">기업명</th>
      <th width="18%">한줄평</th>
      <th width=10%>신고날짜</th>
      <th width="10%">게시글이동</th>
      <th width="10%">블라인드처리</th>
    </tr>
  </thead>

  <tbody>

    <?php

    $query1 ="SELECT * FROM user_declare order by idx desc limit $start,$view_article"; // idx 를 기준으로 내림차순정렬
    mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐
    $result = mysqli_query($connect,$query1);

      while ($rows = mysqli_fetch_assoc($result)) {  //DB 에 저장된 데이터 수 (열 기준)

        $give_user = $rows['give_user'];  // 신고한 유저의 email
        $receive_user = $rows['receive_user'];  // 신고당한 유저의 email
        $board_num = $rows['board_num'];  // 신고 게시물의 idx
        $issue = $rows['issue'];  // 신고 사유
        $date = $rows['date'];  // 날짜

        $issueEx=explode(',',$issue);  // 구분자로 나눔
        $issueCnt = count($issueEx);

        $blind_query = "SELECT * FROM reviewinfo WHERE idx =$board_num";  // 신고당한 게시물의 번호를 가져와서 reviewinfo 의 idx 값에 조회
        mysqli_query($connect,"set names utf8");
        $blind_result = mysqli_query($connect,$blind_query);

         while ($reviewinfo_row = mysqli_fetch_assoc($blind_result)) {
           $blind_value = $reviewinfo_row['isDeleted'];
           $blind_company_name = $reviewinfo_row['company_name'];
           $blind_oneline = $reviewinfo_row['oneline'];

?>
    <tr>
      <td style="vertical-align:middle"><?php echo $give_user; ?></td>
      <td style="text-align:left;vertical-align:middle">
        <?php
        for ($i=0; $i < $issueCnt ; $i++) {
         echo "- ".$issueEx[$i]."<br>";
        }
        ?>
      </td>
      <td style="vertical-align:middle;"><?php echo $receive_user; ?></td>
      <td style="vertical-align:middle;"><?php echo $blind_company_name; ?></td>
      <td style="vertical-align:middle; text-overflow:ellipsis; overflow:hidden"><?php echo $blind_oneline; ?></td>
      <td style="vertical-align:middle;"><?php echo $date; ?></td>
      <td style="vertical-align:middle;"><a class="btn btn-success" href="board_view.php?idx=<?php echo $board_num; ?>">이동</a></td>
      <td style="vertical-align:middle;">

        <?php if ($blind_value != 1) {  // 블라인드처리 되지 않았다면
      ?>
      <form class="" action="blind_board.php" method="post">
      <input type="hidden" name="board_idx" value="<?php echo $board_num; ?>" />
      <input type="hidden" name="user_email" value="" />
      <input type="submit" class="btn btn-warning" value="블라인드">
      </form>

    <?php } else {?>

      <form class="" action="blind_cancel_board.php" method="post">
      <input type="hidden" name="board_idx" value="<?php echo $board_num; ?>" />
      <input type="hidden" name="user_email" value="" />
      <input type="submit" class="btn btn-primary" value="해제" style="width:80px;">
      </form>

    <?php } ?>
  </td>
    </tr>
 <?php
         }
      }
     ?>

  </tbody>

</table>

<br><br>
<?php
$total_page = ceil($total_article / $view_article);

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


  </body>

</html>
