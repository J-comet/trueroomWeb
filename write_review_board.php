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

    $idx = $row['idx']; // reviewinfo 테이블에 저장시킬 idx 값
    $email = $row['email'];
    $name = $row['name'];
    $admin = $row['admin'];
    $password = $row['password'];
    $gender = $row['gender'];
    $verify = $row['verify'];
    $company_name = $row['company_name'];
    $account_pause = $row['account_pause'];

  }
?><?php
if ($account_pause == 1) {
  echo"
  <script>
  alert('관리자에의해 정지된 계정입니다');
  location.replace('index.php');
  </script>";
}



if ($verify == 0) {
 ?><script>
   alert('잘못된접근입니다');
   history.back();
 </script> <?php
}

 ?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/write_review_board.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Include the above in your HEAD tag ------>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

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
  .fa{
    color:yellow;
  }

  /*  input type=text 를 hidden 을 안쓰고 hidden 처럼 숨겨지게 하고 싶을 때 사용  */
  .input_hidden{
    height: 0;
    width: 0;
    visibility: hidden;
    padding:0;
    margin: 0;

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
<br><br><br>
<h1 class="text-center">기업리뷰 작성</h1>
<p class="text-center" style="color:gray">솔직하게 작성해주세요</p>

<br>
<center><hr style="width:50%"></center>

<div style="width:45%; margin:0 auto; height:auto; padding-left:25px;">

  <form action="write_review_db.php" method="post">

<br>
  <input type="hidden" name="username" value="<?php echo $name; ?>">
   <input type="hidden" name="gender" value="<?php echo $gender; ?>">
   <input type="hidden" name="memberidx" value="<?php echo $idx; ?>">

  <div class="cp_div">
    기업명<label for="input_cpname"></label>
  <input type="text" style="margin-left:80px; background:#e2e2e2" maxlength="40" name="company_name" id="input_cpname" value="<?php echo $company_name; ?>" readonly>
  </div>
<br>
  <div class="work_div">
    재직여부
    <span style="margin-left:65px;"></span>
    <input type="radio" id="check_work1" name="check_work" value="현직장" checked><label for="check_work1">현직장</label>
    <input type="radio" id="check_work2" name="check_work" value="전직장"><label for="check_work2">전직장</label>
  </div>
<br>

<div class="job_div">
  직종

  <select name="what_job" required style="margin-left:100px;">

    <option value="">&nbsp&nbsp직종선택</option>
    <option value="IT/인터넷">&nbsp&nbspIT/인터넷</option>
    <option value="경영/기획/컨설팅">&nbsp&nbsp경영/기획/컨설팅</option>
    <option value="교육">&nbsp&nbsp교육</option>
    <option value="금융/재무">&nbsp&nbsp금융/재무</option>
    <option value="디자인">&nbsp&nbsp디자인</option>
    <option value="마케팅/시장조사">&nbsp&nbsp마케팅/시장조사</option>
    <option value="미디어/홍보">&nbsp&nbsp미디어/홍보</option>
    <option value="법률/법무">&nbsp&nbsp법률/법무</option>
    <option value="생산/제조">&nbsp&nbsp생산/제조</option>
    <option value="생산관리/품질관리">&nbsp&nbsp생산관리/품질관리</option>
    <option value="서비스/고객지원">&nbsp&nbsp서비스/고객지원</option>
    <option value="엔지니어링">&nbsp&nbsp엔지니어링</option>
    <option value="연구개발">&nbsp&nbsp연구개발</option>
    <option value="영업/제휴">&nbsp&nbsp영업/제휴</option>
    <option value="유통/무역">&nbsp&nbsp유통/무역</option>
    <option value="의약">&nbsp&nbsp의약</option>
    <option value="인사/총무">&nbsp&nbsp인사/총무</option>
    <option value="전문직">&nbsp&nbsp전문직</option>
    <option value="특수계층/공공">&nbsp&nbsp특수계층/공공</option>

    </optgroup>

     </select>
</div>
<br>
<div class="how_div">
  고용형태
  <select name="how_work" required style="margin-left:70px;">

    <option value="">&nbsp&nbsp고용형태</option>
    <option value="인턴직">&nbsp&nbsp인턴직</option>
    <option value="아르바이트">&nbsp&nbsp아르바이트</option>
    <option value="정규직">&nbsp&nbsp정규직</option>
    <option value="계약직">&nbsp&nbsp계약직</option>
    <option value="프리랜서">&nbsp&nbsp프리랜서</option>
    <option value="기타">&nbsp&nbsp기타</option>

    </optgroup>
     </select>
</div>
<br>

<div class="how_div">
  재직기간

  <select name="how_long" required style="margin-left:70px;">

    <option value="">&nbsp&nbsp재직기간</option>
    <option value="1년미만">&nbsp&nbsp1년미만</option>
    <option value="1년이상">&nbsp&nbsp1년이상</option>
    <option value="2년이상">&nbsp&nbsp2년이상</option>
    <option value="3년이상">&nbsp&nbsp3년이상</option>
    <option value="5년이상">&nbsp&nbsp5년이상</option>
    <option value="10년이상">&nbsp&nbsp10년이상</option>

    </optgroup>
     </select>
</div>
<br>

<div class="where_div">
  근무지역

  <select name="where_work" required style="margin-left:70px;">

    <option value="">&nbsp&nbsp근무지역</option>
    <option value="서울">&nbsp&nbsp서울</option>
    <option value="경기">&nbsp&nbsp경기</option>
    <option value="인천">&nbsp&nbsp인천</option>
    <option value="부산">&nbsp&nbsp부산</option>
    <option value="대구">&nbsp&nbsp대구</option>
    <option value="대전">&nbsp&nbsp대전</option>
    <option value="광주">&nbsp&nbsp광주</option>
    <option value="울산">&nbsp&nbsp울산</option>
    <option value="세종">&nbsp&nbsp세종</option>
    <option value="강원">&nbsp&nbsp강원</option>
    <option value="경남">&nbsp&nbsp경남</option>
    <option value="경북">&nbsp&nbsp경북</option>
    <option value="전남">&nbsp&nbsp전남</option>
    <option value="전북">&nbsp&nbsp전북</option>
    <option value="충남">&nbsp&nbsp충남</option>
    <option value="충북">&nbsp&nbsp충북</option>
    <option value="제주">&nbsp&nbsp제주</option>
    <option value="해외">&nbsp&nbsp해외</option>
    <option value="기타">&nbsp&nbsp기타</option>

    </optgroup>
     </select>
</div>
<br>

<div class="cp_div">
  연봉<label for="input_money"></label>
<input type="text" name="company_money" id="input_money" style="margin-left:100px; width:350px; text-align:right;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')" required>&nbsp&nbsp 만원
</div>
<br>

<div class="oneline_div">
  <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
    기업 한줄평<br><font style="font-size:13px">(최소 20~최대 150자)</font>
  </div>
  <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
  <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="oneline" required></textarea>
  </div>

</div>

<br><br><br><br><br><br><br>

<div class="oneline_div">
  <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
    기업의 장점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
  </div>
  <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
  <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="advantage" required></textarea>
  </div>

</div>

<br><br><br><br><br><br><br>

<div class="oneline_div">
  <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
    기업의 단점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
  </div>
  <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
  <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="dis_advantage" required></textarea>
  </div>

</div>

<br><br><br><br><br><br><br>

<div class="oneline_div">
  <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
    경영진에 바라는점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
  </div>
  <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
  <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="company_required" required></textarea>
  </div>

</div>

<br><br><br><br><br><br><br><br>

<div>

  <div style="width:25%; box-sizing: border-box;float:left;">
  승진기회 및 가능성
  </div>

    <script>
    $(document).ready(function($){

  //  var clicked = 0;

    $(".btnrating1").on('click',(function(e) {   // 별점을 선택했을 때 실행

    // clicked++; // 승진 별점을 클릭할때마다 1씩 증가 ( 선택했는지 안했는지 알기 위해 사용 )

    var previous_value = $("#chance_possible_rating").val();  // 선택된 것의 이전 버튼들도 모두 선택되도록하기위한 변수
    var selected_value = $(this).attr("data-attr");

    var choice = "";

    $("#chance_possible_rating").val(selected_value);

    $(".chance_possible_span").empty();

    if (selected_value == 1) {
      choice = "(매우불만족)";
    } else if (selected_value == 2) {
        choice = "(불만족)";
    } else if (selected_value == 3) {
        choice = "(보통)";
    } else if (selected_value == 4) {
        choice = "(만족)";
    } else if (selected_value == 5) {
        choice = "(매우만족)";
    }

    $(".chance_possible_span").html(choice);   // selected_rating 클래스인 span 태그에 회사평가글띄우기

    for (i = 1; i <= selected_value; ++i) {
    $("#1rating-star-"+i).toggleClass('btn-primary');
    $("#1rating-star-"+i).toggleClass('btn-secondary');
    }

    for (ix = 1; ix <= previous_value; ++ix) {
    $("#1rating-star-"+ix).toggleClass('btn-primary');
    $("#1rating-star-"+ix).toggleClass('btn-secondary');
    }


    }));
    });
    </script>
    <div class="form-group" id="rating-ability-wrapper" style="margin:0">
          <label class="control-label" for="rating">

          <span class="field-label-info"></span>
          <input type="hidden" id="chance_possible_rating" name="chance_possible_rating" value="" required="required">
          </label>

          <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="1" id="1rating-star-1">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="2" id="1rating-star-2">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="3" id="1rating-star-3">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="4" id="1rating-star-4">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="5" id="1rating-star-5">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
      </div>
      <span style="color:gray; font-size:13px;" class="chance_possible_span"></span>

</div>

<br><br>

<div>

  <div style="width:25%; box-sizing: border-box;float:left;">
  복지 및 급여
  </div>

    <script>
    $(document).ready(function($){

    var clicked2 = 0; // 복지 및 급여 별점 선택했는지의 여부를 확인하는 변수


    $(".btnrating2").on('click',(function(e) {

  //  clicked2++; // 복지 및 연봉 별점을 클릭할때마다 1씩 증가 ( 선택했는지 안했는지 알기 위해 사용 )

    var previous_value = $("#health_money_rating").val();  // 선택된 것의 이전 버튼들도 모두 선택되도록하기위한 변수
    var selected_value = $(this).attr("data-attr");

    var choice = "";

    $("#health_money_rating").val(selected_value);

    $(".health_money_span").empty();

    if (selected_value == 1) {
      choice = "(매우불만족)";
    } else if (selected_value == 2) {
        choice = "(불만족)";
    } else if (selected_value == 3) {
        choice = "(보통)";
    } else if (selected_value == 4) {
        choice = "(만족)";
    } else if (selected_value == 5) {
        choice = "(매우만족)";
    }

    $(".health_money_span").html(choice);   // selected_rating 클래스인 span 태그에 회사평가글띄우기

    for (i = 1; i <= selected_value; ++i) {
    $("#2rating-star-"+i).toggleClass('btn-primary');
    $("#2rating-star-"+i).toggleClass('btn-secondary');
    }

    for (ix = 1; ix <= previous_value; ++ix) {
    $("#2rating-star-"+ix).toggleClass('btn-primary');
    $("#2rating-star-"+ix).toggleClass('btn-secondary');
    }


    }));
    });
    </script>
    <div class="form-group" id="rating-ability-wrapper" style="margin:0">
          <label class="control-label" for="rating">

          <span class="field-label-info"></span>
          <input type="hidden" id="health_money_rating" name="health_money_rating" value="" required="required">
          </label>

          <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="1" id="2rating-star-1">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="2" id="2rating-star-2">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="3" id="2rating-star-3">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="4" id="2rating-star-4">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="5" id="2rating-star-5">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
      </div>
      <span style="color:gray; font-size:13px;" class="health_money_span"></span>


</div>

<br><br>

<div>


  <div style="width:25%; box-sizing: border-box;float:left;">
  업무와 삶의 균형
  </div>

    <script>
    $(document).ready(function($){

    $(".btnrating3").on('click',(function(e) {

    //  clicked3++; // 업무와 삶의 균형 별점을 클릭할때마다 1씩 증가 ( 선택했는지 안했는지 알기 위해 사용 )

    var previous_value = $("#work_life_rating").val();  // 선택된 것의 이전 버튼들도 모두 선택되도록하기위한 변수
    var selected_value = $(this).attr("data-attr");

    var choice = "";

    $("#work_life_rating").val(selected_value);

    $(".work_life_span").empty();

    if (selected_value == 1) {
      choice = "(매우불만족)";
    } else if (selected_value == 2) {
        choice = "(불만족)";
    } else if (selected_value == 3) {
        choice = "(보통)";
    } else if (selected_value == 4) {
        choice = "(만족)";
    } else if (selected_value == 5) {
        choice = "(매우만족)";
    }

    $(".work_life_span").html(choice);   // selected_rating 클래스인 span 태그에 회사평가글띄우기

    for (i = 1; i <= selected_value; ++i) {
    $("#3rating-star-"+i).toggleClass('btn-primary');
    $("#3rating-star-"+i).toggleClass('btn-secondary');
    }

    for (ix = 1; ix <= previous_value; ++ix) {
    $("#3rating-star-"+ix).toggleClass('btn-primary');
    $("#3rating-star-"+ix).toggleClass('btn-secondary');
    }


    }));
    });
    </script>
    <div class="form-group" id="rating-ability-wrapper" style="margin:0">
          <label class="control-label" for="rating">

          <span class="field-label-info"></span>
          <input type="hidden" id="work_life_rating" name="work_life_rating" value="" required="required">
          </label>

          <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="1" id="3rating-star-1">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="2" id="3rating-star-2">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="3" id="3rating-star-3">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="4" id="3rating-star-4">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="5" id="3rating-star-5">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
      </div>
      <span style="color:gray; font-size:13px;" class="work_life_span"></span>


</div>

<br><br>

<div>
  <div style="width:25%; box-sizing: border-box;float:left;">
  사내문화
  </div>

    <script>
    $(document).ready(function($){

    $(".btnrating4").on('click',(function(e) {

  //  clicked4++; // 업무와 삶의 균형 별점을 클릭할때마다 1씩 증가 ( 선택했는지 안했는지 알기 위해 사용 )

    var previous_value = $("#in_company_rating").val();  // 선택된 것의 이전 버튼들도 모두 선택되도록하기위한 변수
    var selected_value = $(this).attr("data-attr");

    var choice = "";

    $("#in_company_rating").val(selected_value);

    $(".in_company_span").empty();

    if (selected_value == 1) {
      choice = "(매우불만족)";
    } else if (selected_value == 2) {
        choice = "(불만족)";
    } else if (selected_value == 3) {
        choice = "(보통)";
    } else if (selected_value == 4) {
        choice = "(만족)";
    } else if (selected_value == 5) {
        choice = "(매우만족)";
    }

    $(".in_company_span").html(choice);   // selected_rating 클래스인 span 태그에 회사평가글띄우기

    for (i = 1; i <= selected_value; ++i) {
    $("#4rating-star-"+i).toggleClass('btn-primary');
    $("#4rating-star-"+i).toggleClass('btn-secondary');
    }

    for (ix = 1; ix <= previous_value; ++ix) {
    $("#4rating-star-"+ix).toggleClass('btn-primary');
    $("#4rating-star-"+ix).toggleClass('btn-secondary');
    }


    }));
    });
    </script>
    <div class="form-group" id="rating-ability-wrapper" style="margin:0">
          <label class="control-label" for="rating">

          <span class="field-label-info"></span>
          <input type="hidden" id="in_company_rating" name="in_company_rating" value="" required>
          </label>

          <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="1" id="4rating-star-1">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="2" id="4rating-star-2">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="3" id="4rating-star-3">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="4" id="4rating-star-4">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
          <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="5" id="4rating-star-5">
              <i class="fa fa-star" aria-hidden="true"></i>
          </button>
      </div>
      <span style="color:gray; font-size:13px;" class="in_company_span"></span>

</div>

<br><br>

<div>
  <div style="width:25%; box-sizing: border-box; float:left;">
  경영진
  </div>

  <script>
  $(document).ready(function($){

  $(".btnrating5").on('click',(function(e) {

  //clicked5++; // 업무와 삶의 균형 별점을 클릭할때마다 1씩 증가 ( 선택했는지 안했는지 알기 위해 사용 )

  var previous_value = $("#operate_rating").val();  // 선택된 것의 이전 버튼들도 모두 선택되도록하기위한 변수
  var selected_value = $(this).attr("data-attr");

  var choice = "";

  $("#operate_rating").val(selected_value);

  $(".operate_span").empty();

  if (selected_value == 1) {
    choice = "(매우불만족)";
  } else if (selected_value == 2) {
      choice = "(불만족)";
  } else if (selected_value == 3) {
      choice = "(보통)";
  } else if (selected_value == 4) {
      choice = "(만족)";
  } else if (selected_value == 5) {
      choice = "(매우만족)";
  }

  $(".operate_span").html(choice);   // selected_rating 클래스인 span 태그에 회사평가글띄우기

  for (i = 1; i <= selected_value; ++i) {
  $("#5rating-star-"+i).toggleClass('btn-primary');
  $("#5rating-star-"+i).toggleClass('btn-secondary');
  }

  for (ix = 1; ix <= previous_value; ++ix) {
  $("#5rating-star-"+ix).toggleClass('btn-primary');
  $("#5rating-star-"+ix).toggleClass('btn-secondary');
  }


  }));
  });
  </script>

  <div class="form-group" id="rating-ability-wrapper" style="margin:0">
        <label class="control-label" for="rating">

        <span class="field-label-info"></span>
        </label>

        <input type="hidden" id="operate_rating" name="operate_rating" value="" required>

        <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="1" id="5rating-star-1">
            <i class="fa fa-star" aria-hidden="true"></i>
        </button>
        <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="2" id="5rating-star-2">
            <i class="fa fa-star" aria-hidden="true"></i>
        </button>
        <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="3" id="5rating-star-3">
            <i class="fa fa-star" aria-hidden="true"></i>
        </button>
        <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="4" id="5rating-star-4">
            <i class="fa fa-star" aria-hidden="true"></i>
        </button>
        <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="5" id="5rating-star-5">
            <i class="fa fa-star" aria-hidden="true"></i>
        </button>
    </div>
    <span id="operate" style="color:gray; font-size:13px; margin:0;" class="operate_span"></span>

<!-- <span class="selected-rating">0</span><small> / 5</small> -->
</div>



<br><br><br>



</script>



<script type="text/javascript">
$(document).ready(function($){

 // 현재 php 파일 안에서 별점을 다 입력했는지 확인하기 위해 클릭했는지의 여부를 검사하도록 함
// var clicked = 0;  // 승진기회 별점 선택했는지의 여부를 확인하는 변수
//var clicked2 = 0; // 복지 및 급여 별점 선택했는지의 여부를 확인하는 변수
//var clicked3 = 0; // 업무와 삶의 균형 별점 선택했는지의 여부를 확인하는 변수
//var clicked4 = 0; // 사내문화 별점 선택했는지의 여부를 확인하는 변수
//var clicked5 = 0; // 경영진 별점 선택했는지의 여부를 확인하는 변수

$("#write_submit").on('click',(function(e) {   // 작성완료 버튼을 클릭 했을 때 실행


var value = $("#chance_possible_rating").val();  // 승진 및 기회의 별점 값 변수
var value2 = $("#health_money_rating").val();  // 복지 및 연봉의 별점 값 변수
var value3 = $("#work_life_rating").val();  // 업무와 삶의균형의 별점 값 변수
var value4 = $("#in_company_rating").val();  // 사내문화의 별점 값 변수
var value5 = $("#operate_rating").val();  // 경영진의 별점 값 변수



if (value == '') {
  alert('승진 및 기회에 대한 별점을 선택해주세요');
  return false;

}


if (value2 == '') {
  alert('복지 및 연봉에 대한 별점을 선택해주세요');
  return false;

}


if (value3 == '') {
  alert('업무와 삶의균형에 대한 별점을 선택해주세요');
  return false;

}


if (value4 == '') {
  alert('사내문화에 대한 별점을 선택해주세요');
  return false;

}

if (value5 == '') {
  alert('경영진에 대한 별점을 선택해주세요');
  return false;

}


/*
  if (clicked <= 0) {

    alert('승진기회 및 가능성 별점을 선택해주세요');
    return false;

  } else if (clicked2 <= 0) {

    alert('복지 및 급여 별점을 선택해주세요');
    return false;

  } else if (clicked3 <= 0) {

    alert('업무와 삶의 균형 별점을 선택해주세요');
    return false;

  } else if (clicked4 <= 0) {

     alert('사내문화 별점을 선택해주세요');
     return false;

  } else if (clicked5 <= 0){

    alert('경영진 별점을 선택해주세요');
    return false;

  } else {
    return true;
  }
*/
}));
});

</script>


<center><input id="write_submit" class="btn btn-primary btn-lg" type="submit" value="작성완료"></center>
<!-- 기업리뷰작성 끝지점 -->
</form>
</div>



    <br><br><br><br>
      <!-- Footer -->
      <footer class="py-5 bg-primary">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; (주)진실의방 2020</p>
        </div>
      </footer>


  </body>

</html>
