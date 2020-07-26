<?php
session_start();

$email = $_SESSION['useremail'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$bno =$_GET['idx'];
$query = "SELECT * FROM reviewinfo WHERE idx ='{$bno}'"; // idx 로 해당게시물을 찾음

$result = mysqli_query($connect,$query);
mysqli_query($connect,"set names utf8");
$res = $connect->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);

  $company_name = $row['company_name'];
  $check_work = $row['check_work'];
  $what_job = $row['what_job'];
  $how_work = $row['how_work'];
  $how_long = $row['how_long'];
  $where_work = $row['where_work'];
  $company_money = $row['company_money'];
  $oneline= $row['oneline'];
  $advantage = $row['advantage'];
  $dis_advantage = $row['dis_advantage'];
  $company_required = $row['company_required'];

  $chance_possible = $row['chance_possible'];
  $health_money= $row['health_money'];
  $work_life = $row['work_life'];
  $in_company = $row['in_company'];
  $operate = $row['operate'];

  $total = ($chance_possible + $health_money + $work_life + $in_company + $operate) / 5;

}

$query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

$res = mysqli_query($connect,$query);
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$res = $connect->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);

  $name = $row['name'];
  //$gender = $row['gender']; // 성별
  $admin = $row['admin'];  // 관리자인지 확인
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

$date = date('Y-m-d H:i:s');  // 날짜
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
    /*margin-left: 500px;*/;
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
   .prev_btn{
     color:#fff;
     background-color:#2FA4E7;
     border-color:#2FA4E7
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
 <h1 class="text-center">기업리뷰 수정</h1>
 <p class="text-center" style="color:gray">잘못 입력된 정보를 수정해주세요</p>

 <br>
 <center><hr style="width:50%"></center>

 <div style="width:45%; margin:0 auto; height:auto; padding-left:25px;">

   <form action="modify_board_view_db.php" method="post">

          <input type="hidden" name="hidden_idx" value="<?php echo $bno; ?>">
         <input type="hidden" name="hidden_chance_possible" value="<?php echo $chance_possible; ?>">
         <input type="hidden" name="hidden_health_money" value="<?php echo $health_money; ?>">
         <input type="hidden" name="hidden_work_life" value="<?php echo $work_life; ?>">
         <input type="hidden" name="hidden_in_company" value="<?php echo $in_company; ?>">
         <input type="hidden" name="hidden_operate" value="<?php echo $operate; ?>">

 <br>

   <div class="cp_div">
     기업명<label for="input_cpname"></label>
   <input type="text" style="margin-left:80px;background:#e2e2e2" maxlength="40" name="company_name" id="input_cpname" value="<?php echo $company_name; ?>" readonly>
   </div>
 <br>
   <div class="work_div">
     재직여부
       <span style="margin-left:65px;"></span>
     <input type="radio" id="check_work1" name="check_work" value="현직장" <?php if($check_work=="현직장"):?> checked <?php endif ?>><label for="check_work1">현직장</label>
     <input type="radio" id="check_work2" name="check_work" value="전직장" <?php if($check_work=="전직장"):?> checked <?php endif ?>><label for="check_work2">전직장</label>
   </div>
 <br>

 <div class="job_div">
   직종

   <select name="what_job" required style="margin-left:100px;">

     <option value="">&nbsp&nbsp직종선택</option>
     <option value="IT/인터넷" <?php if($what_job=="IT/인터넷"):?> selected <?php endif ?> >&nbsp&nbspIT/인터넷</option>
     <option value="경영/기획/컨설팅" <?php if($what_job=="경영/기획/컨설팅"):?> selected <?php endif ?>>&nbsp&nbsp경영/기획/컨설팅</option>
     <option value="교육" <?php if($what_job=="교육"):?> selected <?php endif ?>>&nbsp&nbsp교육</option>
     <option value="금융/재무" <?php if($what_job=="금융/재무"):?> selected <?php endif ?>>&nbsp&nbsp금융/재무</option>>&nbsp&nbsp금융/재무</option>
     <option value="디자인" <?php if($what_job=="디자인"):?> selected <?php endif ?>>&nbsp&nbsp디자인</option>
     <option value="마케팅/시장조사" <?php if($what_job=="마케팅/시장조사"):?> selected <?php endif ?>>&nbsp&nbsp마케팅/시장조사</option>
     <option value="미디어/홍보" <?php if($what_job=="미디어/홍보"):?> selected <?php endif ?>>&nbsp&nbsp미디어/홍보</option>
     <option value="법률/법무" <?php if($what_job=="법률/법무"):?> selected <?php endif ?>>&nbsp&nbsp법률/법무</option>
     <option value="생산/제조" <?php if($what_job=="생산/제조"):?> selected <?php endif ?>>&nbsp&nbsp생산/제조</option>
     <option value="생산관리/품질관리" <?php if($what_job=="생산관리/품질관리"):?> selected <?php endif ?>>&nbsp&nbsp생산관리/품질관리</option>
     <option value="서비스/고객지원" <?php if($what_job=="서비스/고객지원"):?> selected <?php endif ?>>&nbsp&nbsp서비스/고객지원</option>
     <option value="엔지니어링" <?php if($what_job=="엔지니어링"):?> selected <?php endif ?>>&nbsp&nbsp엔지니어링</option>
     <option value="연구개발" <?php if($what_job=="연구개발"):?> selected <?php endif ?>>&nbsp&nbsp연구개발</option>
     <option value="영업/제휴" <?php if($what_job=="영업/제휴"):?> selected <?php endif ?>>&nbsp&nbsp영업/제휴</option>
     <option value="유통/무역" <?php if($what_job=="유통/무역"):?> selected <?php endif ?>>&nbsp&nbsp유통/무역</option>
     <option value="의약" <?php if($what_job=="의약"):?> selected <?php endif ?>>&nbsp&nbsp의약</option>
     <option value="인사/총무" <?php if($what_job=="인사/총무"):?> selected <?php endif ?>>&nbsp&nbsp인사/총무</option>
     <option value="전문직" <?php if($what_job=="전문직"):?> selected <?php endif ?>>&nbsp&nbsp전문직</option>
     <option value="특수계층/공공" <?php if($what_job=="특수계층/공공"):?> selected <?php endif ?>>&nbsp&nbsp특수계층/공공</option>

     </optgroup>

      </select>
 </div>
 <br>
 <div class="how_div">
   고용형태

   <select name="how_work" required style="margin-left:70px;">

     <option value="">&nbsp&nbsp고용형태</option>
     <option value="인턴직" <?php if($how_work=="인턴직"):?> selected <?php endif ?>>&nbsp&nbsp인턴직</option>
     <option value="아르바이트" <?php if($how_work=="아르바이트"):?> selected <?php endif ?>>&nbsp&nbsp아르바이트</option>
     <option value="정규직" <?php if($how_work=="정규직"):?> selected <?php endif ?>>&nbsp&nbsp정규직</option>
     <option value="계약직" <?php if($how_work=="계약직"):?> selected <?php endif ?>>&nbsp&nbsp계약직</option>
     <option value="프리랜서" <?php if($how_work=="프리랜서"):?> selected <?php endif ?>>&nbsp&nbsp프리랜서</option>
     <option value="기타" <?php if($how_work=="기타"):?> selected <?php endif ?>>&nbsp&nbsp기타</option>

     </optgroup>
      </select>
 </div>
 <br>

 <div class="how_div">
   재직기간
   <select name="how_long" required style="margin-left:70px;">

     <option value="">&nbsp&nbsp재직기간</option>
     <option value="1년미만" <?php if($how_long=="1년미만"):?> selected <?php endif ?>>&nbsp&nbsp1년미만</option>
     <option value="1년이상" <?php if($how_long=="1년이상"):?> selected <?php endif ?>>&nbsp&nbsp1년이상</option>
     <option value="2년이상" <?php if($how_long=="2년이상"):?> selected <?php endif ?>>&nbsp&nbsp2년이상</option>
     <option value="3년이상" <?php if($how_long=="3년이상"):?> selected <?php endif ?>>&nbsp&nbsp3년이상</option>
     <option value="5년이상" <?php if($how_long=="5년이상"):?> selected <?php endif ?>>&nbsp&nbsp5년이상</option>
     <option value="10년이상" <?php if($how_long=="10년이상"):?> selected <?php endif ?>>&nbsp&nbsp10년이상</option>

     </optgroup>
      </select>
 </div>
 <br>

 <div class="where_div">
   근무지역

   <select name="where_work" required style="margin-left:70px;">

     <option value="">&nbsp&nbsp근무지역</option>
     <option value="서울" <?php if($where_work=="서울"):?> selected <?php endif ?>>&nbsp&nbsp서울</option>
     <option value="경기" <?php if($where_work=="경기"):?> selected <?php endif ?>>&nbsp&nbsp경기</option>
     <option value="인천" <?php if($where_work=="인천"):?> selected <?php endif ?>>&nbsp&nbsp인천</option>
     <option value="부산" <?php if($where_work=="부산"):?> selected <?php endif ?>>&nbsp&nbsp부산</option>
     <option value="대구" <?php if($where_work=="대구"):?> selected <?php endif ?>>&nbsp&nbsp대구</option>
     <option value="대전" <?php if($where_work=="대전"):?> selected <?php endif ?>>&nbsp&nbsp대전</option>
     <option value="광주" <?php if($where_work=="광주"):?> selected <?php endif ?>>&nbsp&nbsp광주</option>
     <option value="울산" <?php if($where_work=="울산"):?> selected <?php endif ?>>&nbsp&nbsp울산</option>
     <option value="세종" <?php if($where_work=="세종"):?> selected <?php endif ?>>&nbsp&nbsp세종</option>
     <option value="강원" <?php if($where_work=="강원"):?> selected <?php endif ?>>&nbsp&nbsp강원</option>
     <option value="경남" <?php if($where_work=="경남"):?> selected <?php endif ?>>&nbsp&nbsp경남</option>
     <option value="경북" <?php if($where_work=="경북"):?> selected <?php endif ?>>&nbsp&nbsp경북</option>
     <option value="전남" <?php if($where_work=="전남"):?> selected <?php endif ?>>&nbsp&nbsp전남</option>
     <option value="전북" <?php if($where_work=="전북"):?> selected <?php endif ?>>&nbsp&nbsp전북</option>
     <option value="충남" <?php if($where_work=="충남"):?> selected <?php endif ?>>&nbsp&nbsp충남</option>
     <option value="충북" <?php if($where_work=="충북"):?> selected <?php endif ?>>&nbsp&nbsp충북</option>
     <option value="제주" <?php if($where_work=="제주"):?> selected <?php endif ?>>&nbsp&nbsp제주</option>
     <option value="해외" <?php if($where_work=="해외"):?> selected <?php endif ?>>&nbsp&nbsp해외</option>
     <option value="기타" <?php if($where_work=="기타"):?> selected <?php endif ?>>&nbsp&nbsp기타</option>

     </optgroup>
      </select>
 </div>
 <br>

 <div class="cp_div">
   연봉<label for="input_money"></label>
 <input type="text" value="<?php echo $company_money; ?>" name="company_money" id="input_money" style="margin-left:100px; width:350px;" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')" required>&nbsp&nbsp 만원
 </div>
 <br>

 <div class="oneline_div">
   <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
     기업 한줄평<br><font style="font-size:13px">(최소 20~최대 150자)</font>
   </div>
   <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
   <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="oneline" required><?php echo $oneline; ?>
   </textarea>
   </div>

 </div>

 <br><br><br><br><br><br><br>

 <div class="oneline_div">
   <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
     기업의 장점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
   </div>
   <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
   <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="advantage" required><?php echo $advantage; ?>
   </textarea>
   </div>

 </div>

 <br><br><br><br><br><br><br>

 <div class="oneline_div">
   <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
     기업의 단점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
   </div>
   <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
   <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="dis_advantage" required><?php echo $dis_advantage; ?>
   </textarea>
   </div>

 </div>

 <br><br><br><br><br><br><br>

 <div class="oneline_div">
   <div class="oneline_div_left" style="width:21%; box-sizing: border-box; float:left;">
     경영진에 바라는점<br><font style="font-size:13px">(최소 20~최대 150자)</font>
   </div>
   <div class="oneline_div_right" style="width:79%; box-sizing: border-box; float:right;">
   <textarea minlength="20" maxlength="150" style="border: 1px solid skyblue; resize:none; width:75%; height:150px;" name="company_required" required><?php echo $company_required; ?>
   </textarea>
   </div>

 </div>

 <br><br><br><br><br><br><br><br>



 <div>


   <div style="width:25%; box-sizing: border-box;float:left;">
   승진기회 및 가능성
   </div>

<script type="text/javascript">
 $(document).ready(function($){
$(".btnrating1").one('click',function(){

   if ($('.btnrating1').hasClass("prev_btn") === true) {
     $('.btnrating1').removeClass("prev_btn");
     $('.btnrating1').addClass("btn-secondary");
     //alert("one function 실행");
   }

       });
    });
</script>

<script>
     $(document).ready(function($){

   $(".btnrating1").on('click',(function(e) {

    // $('button').one().removeClass("btn-warning");
    // $('button').one().addClass("btn-secondary");

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

           <?php
                if ($chance_possible == 1) {
                      ?>
     <span>
           <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="1" id="1rating-star-1">
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
         </span>
<?php } else if ($chance_possible == 2) {?>


          <span>
               <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="1" id="1rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="2" id="1rating-star-2">
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
           </span>
<?php }  else if ($chance_possible == 3) {?>


            <span>
                 <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="1" id="1rating-star-1">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="2" id="1rating-star-2">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="3" id="1rating-star-3">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="4" id="1rating-star-4">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="5" id="1rating-star-5">
                   <i class="fa fa-star" aria-hidden="true"></i>
                </button>
             </span>
<?php } else if ($chance_possible == 4) {?>


              <span>
                   <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="1" id="1rating-star-1">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="2" id="1rating-star-2">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="3" id="1rating-star-3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="4" id="1rating-star-4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating1 btn btn-secondary btn-lg" data-attr="5" id="1rating-star-5">
                     <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
               </span>
<?php } else { ?>


                <span>
                     <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="1" id="1rating-star-1">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="2" id="1rating-star-2">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="3" id="1rating-star-3">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="4" id="1rating-star-4">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating1 btn prev_btn btn-lg" data-attr="5" id="1rating-star-5">
                       <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                 </span>
<?php } ?>

       </div>
       <span style="color:gray; font-size:13px;" class="chance_possible_span">
         <?php if ($chance_possible == 1) {
          echo "(매우불만족)";
       } elseif ($chance_possible == 2) {
         echo "(불만족)";
       } elseif ($chance_possible == 3) {
        echo "(보통)";
      } elseif ($chance_possible == 4) {
        echo "(만족)";
      } else {
        echo "(매우만족)";
      }?>
    </span>

 </div>

 <br><br>

 <div>

   <div style="width:25%; box-sizing: border-box;float:left;">
   복지 및 급여
   </div>

   <script type="text/javascript">
    $(document).ready(function($){
   $(".btnrating2").one('click',function(){

      if ($('.btnrating2').hasClass("prev_btn") === true) {
        $('.btnrating2').removeClass("prev_btn");
        $('.btnrating2').addClass("btn-secondary");
      //  alert("실행");
      }

          });
       });
   </script>

     <script>
     $(document).ready(function($){

     $(".btnrating2").on('click',(function(e) {

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

           <?php
                if ($health_money == 1) {
                      ?>
     <span>
           <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="1" id="2rating-star-1">
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
         </span>
 <?php } else if ($health_money == 2) {?>


          <span>
               <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="1" id="2rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="2" id="2rating-star-2">
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
           </span>
 <?php }  else if ($health_money == 3) {?>


            <span>
                 <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="1" id="2rating-star-1">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="2" id="2rating-star-2">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="3" id="2rating-star-3">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="4" id="2rating-star-4">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="5" id="2rating-star-5">
                   <i class="fa fa-star" aria-hidden="true"></i>
                </button>
             </span>
 <?php } else if ($health_money == 4) {?>


              <span>
                   <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="1" id="2rating-star-1">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="2" id="2rating-star-2">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="3" id="2rating-star-3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="4" id="2rating-star-4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating2 btn btn-secondary btn-lg" data-attr="5" id="2rating-star-5">
                     <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
               </span>
 <?php } else { ?>


                <span>
                     <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="1" id="2rating-star-1">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="2" id="2rating-star-2">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="3" id="2rating-star-3">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="4" id="2rating-star-4">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating2 btn prev_btn btn-lg" data-attr="5" id="2rating-star-5">
                       <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                 </span>
 <?php } ?>
       </div>
       <span style="color:gray; font-size:13px;" class="health_money_span">
         <?php if ($health_money == 1) {
          echo "(매우불만족)";
       } elseif ($health_money == 2) {
         echo "(불만족)";
       } elseif ($health_money == 3) {
        echo "(보통)";
      } elseif ($health_money == 4) {
        echo "(만족)";
      } else {
        echo "(매우만족)";
      }?>
    </span>


 </div>

 <br><br>

 <div>


   <div style="width:25%; box-sizing: border-box;float:left;">
   업무와 삶의 균형
   </div>

   <script type="text/javascript">
    $(document).ready(function($){
   $(".btnrating3").one('click',function(){

      if ($('.btnrating3').hasClass("prev_btn") === true) {
        $('.btnrating3').removeClass("prev_btn");
        $('.btnrating3').addClass("btn-secondary");
      //  alert("실행");
      }

          });
       });
   </script>

     <script>
     $(document).ready(function($){

     $(".btnrating3").on('click',(function(e) {

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

           <?php
                if ($work_life == 1) {
                      ?>
     <span>
           <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="1" id="3rating-star-1">
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
         </span>
 <?php } else if ($work_life == 2) {?>


          <span>
               <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="1" id="3rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="2" id="3rating-star-2">
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
           </span>
 <?php }  else if ($work_life == 3) {?>


            <span>
                 <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="1" id="3rating-star-1">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="2" id="3rating-star-2">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="3" id="3rating-star-3">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="4" id="3rating-star-4">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="5" id="3rating-star-5">
                   <i class="fa fa-star" aria-hidden="true"></i>
                </button>
             </span>
 <?php } else if ($work_life == 4) {?>


              <span>
                   <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="1" id="3rating-star-1">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="2" id="3rating-star-2">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="3" id="3rating-star-3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="4" id="3rating-star-4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating3 btn btn-secondary btn-lg" data-attr="5" id="3rating-star-5">
                     <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
               </span>
 <?php } else { ?>


                <span>
                     <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="1" id="3rating-star-1">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="2" id="3rating-star-2">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="3" id="3rating-star-3">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="4" id="3rating-star-4">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating3 btn prev_btn btn-lg" data-attr="5" id="3rating-star-5">
                       <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                 </span>
 <?php } ?>
       </div>
       <span style="color:gray; font-size:13px;" class="work_life_span">
         <?php if ($work_life == 1) {
          echo "(매우불만족)";
       } elseif ($work_life == 2) {
         echo "(불만족)";
       } elseif ($work_life == 3) {
        echo "(보통)";
      } elseif ($work_life == 4) {
        echo "(만족)";
      } else {
        echo "(매우만족)";
      }?>
    </span>


 </div>

 <br><br>

 <div>
   <div style="width:25%; box-sizing: border-box;float:left;">
   사내문화
   </div>

   <script type="text/javascript">
    $(document).ready(function($){
   $(".btnrating4").one('click',function(){

      if ($('.btnrating4').hasClass("prev_btn") === true) {
        $('.btnrating4').removeClass("prev_btn");
        $('.btnrating4').addClass("btn-secondary");
        //alert("실행");
      }

          });
       });
   </script>

     <script>
     $(document).ready(function($){

     $(".btnrating4").on('click',(function(e) {

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
           <input type="hidden" id="in_company_rating" name="in_company_rating" value="" required="required">
           </label>

           <?php
                if ($in_company == 1) {
                      ?>
     <span>
           <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="1" id="4rating-star-1">
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
         </span>
 <?php } else if ($in_company == 2) {?>


          <span>
               <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="1" id="4rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="2" id="4rating-star-2">
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
           </span>
 <?php }  else if ($in_company == 3) {?>


            <span>
                 <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="1" id="4rating-star-1">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="2" id="4rating-star-2">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="3" id="4rating-star-3">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="4" id="4rating-star-4">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="5" id="4rating-star-5">
                   <i class="fa fa-star" aria-hidden="true"></i>
                </button>
             </span>
 <?php } else if ($in_company == 4) {?>


              <span>
                   <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="1" id="4rating-star-1">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="2" id="4rating-star-2">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="3" id="4rating-star-3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="4" id="4rating-star-4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating4 btn btn-secondary btn-lg" data-attr="5" id="4rating-star-5">
                     <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
               </span>
 <?php } else { ?>


                <span>
                     <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="1" id="4rating-star-1">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="2" id="4rating-star-2">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="3" id="4rating-star-3">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="4" id="4rating-star-4">
                      <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btnrating4 btn prev_btn btn-lg" data-attr="5" id="4rating-star-5">
                       <i class="fa fa-star" aria-hidden="true"></i>
                    </button>
                 </span>
 <?php } ?>

       </div>
       <span style="color:gray; font-size:13px;" class="in_company_span">
         <?php if ($in_company == 1) {
          echo "(매우불만족)";
       } elseif ($in_company == 2) {
         echo "(불만족)";
       } elseif ($in_company == 3) {
        echo "(보통)";
      } elseif ($in_company == 4) {
        echo "(만족)";
      } else {
        echo "(매우만족)";
      }?>
    </span>

 </div>

 <br><br>

 <div>
   <div style="width:25%; box-sizing: border-box; float:left;">
   경영진
   </div>

   <script type="text/javascript">
    $(document).ready(function($){
   $(".btnrating5").one('click',function(){

      if ($('.btnrating5').hasClass("prev_btn") === true) {
        $('.btnrating5').removeClass("prev_btn");
        $('.btnrating5').addClass("btn-secondary");
        //alert("실행");
      }

          });
       });
   </script>

   <script>
   $(document).ready(function($){

   $(".btnrating5").on('click',(function(e) {

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
         <input type="hidden" id="operate_rating" name="operate_rating" value="" required="required">
         </label>


         <?php
              if ($operate == 1) {
                    ?>
   <span>
         <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="1" id="5rating-star-1">
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
       </span>
<?php } else if ($operate == 2) {?>


        <span>
             <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="1" id="5rating-star-1">
              <i class="fa fa-star" aria-hidden="true"></i>
            </button>
            <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="2" id="5rating-star-2">
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
         </span>
<?php }  else if ($operate == 3) {?>


          <span>
               <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="1" id="5rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="2" id="5rating-star-2">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="3" id="5rating-star-3">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="4" id="5rating-star-4">
                <i class="fa fa-star" aria-hidden="true"></i>
              </button>
              <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="5" id="5rating-star-5">
                 <i class="fa fa-star" aria-hidden="true"></i>
              </button>
           </span>
<?php } else if ($operate == 4) {?>


            <span>
                 <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="1" id="5rating-star-1">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="2" id="5rating-star-2">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="3" id="5rating-star-3">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="4" id="5rating-star-4">
                  <i class="fa fa-star" aria-hidden="true"></i>
                </button>
                <button type="button" class="btnrating5 btn btn-secondary btn-lg" data-attr="5" id="5rating-star-5">
                   <i class="fa fa-star" aria-hidden="true"></i>
                </button>
             </span>
<?php } else { ?>


              <span>
                   <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="1" id="5rating-star-1">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="2" id="5rating-star-2">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="3" id="5rating-star-3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="4" id="5rating-star-4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
                  <button type="button" class="btnrating5 btn prev_btn btn-lg" data-attr="5" id="5rating-star-5">
                     <i class="fa fa-star" aria-hidden="true"></i>
                  </button>
               </span>
<?php } ?>
     </div>
     <span style="color:gray; font-size:13px;" class="operate_span">
       <?php if ($operate == 1) {
        echo "(매우불만족)";
     } elseif ($operate == 2) {
       echo "(불만족)";
     } elseif ($operate == 3) {
      echo "(보통)";
    } elseif ($operate == 4) {
      echo "(만족)";
    } else {
      echo "(매우만족)";
    }?>
  </span>
 </div>



 <br><br><br>

 <center><input class="btn btn-primary btn-lg" type="submit" value="수정완료"></center>
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
