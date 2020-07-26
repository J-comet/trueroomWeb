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
    $session_idx = $row['idx'];
    $email = $row['email'];
    $name = $row['name'];
    $admin = $row['admin'];
    $password = $row['password'];
    $verify = $row['verify'];
    $account_pause = $row['account_pause'];

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
    <script type="text/javascript" src="smart22/js/HuskyEZCreator.js" charset="utf-8"></script>


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
  input[type=file] {
      display: none;
  }

  .imgs_wrap {

      border: 0px;
      margin-top: 10px;
      margin-bottom: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      margin-left: 10px;
      margin-right: 10px;
      height: auto;
  }
  .imgs_wrap img {
     /*
      max-width: 150px;
      max-height: 120px;
      */

      max-width: 192px;
      max-height: 147px;
      margin-left: 0px;
      margin-right: 16px;
      border: 0px;
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
  <p>궁금한 점이나 알고 있었던 점을 자유롭게 작성해주세요</p>
</div>

<br><br>
<center><h2>소통공간 게시글 작성</h2></center>
<br><br>

<div style="width:60%; margin-left:auto; margin-right:auto">

  <form id="frm" action="free_board_write_db.php" method="post" enctype="multipart/form-data">

<input type="text" style="width:70%; margin-bottom:15px;" placeholder="제목" id="title" name="title" maxlength="30" required>
<br>
<textarea name="ir1" id="ir1" placeholder="내용" style="resize:none; width:100%; height:400px;" required></textarea>
<br><br>

<!-- 사진등록 시작지점-->
<div class="align-middle" style="width:100%; border-radius:0px; padding:0">
  <div class="card-title" style="margin-top:15px;">
    <!--
    <h5 class="card-title text-center" style="color:#113366;">사진 등록</h5>
  -->


<!--   <script type="text/javascript" src="/js/jquery-3.1.0.min.js" charset="utf-8"></script>  -->
   <script type="text/javascript">

       // 이미지 정보들을 담을 배열
       var sel_files = [];


       $(document).ready(function() {
           $("#input_imgs").on("change", handleImgFileSelect);
       });

       function fileUploadAction() {
           console.log("fileUploadAction");
           $("#input_imgs").trigger('click');
       }

       function handleImgFileSelect(e) {

           // 이미지 정보들을 초기화
           sel_files = [];
           $(".imgs_wrap").empty();

           var files = e.target.files;
           var filesArr = Array.prototype.slice.call(files);

           var index = 0;
           filesArr.forEach(function(f) {
               if(!f.type.match("image.*")) {
                   alert("확장자는 이미지 확장자만 가능합니다.");
                   return;
               }

                /*
                // 최대 업로드 갯수 5개로 하고 싶을 때
               if(sel_files.length > 5) {
                 alert("최대 5개까지 올릴 수 있습니다.");
                 for (var i = 0; i < sel_files.length; i++) {
                    deleteImageAction("+index[i]+");
                 }
                 return;
             }
             */
               sel_files.push(f);

               var reader = new FileReader();
               reader.onload = function(e) {
                 var html = "<img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'>";

                  // var html = "<a href=\"javascript:void(0);\" onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\"><img src=\"" + e.target.result + "\" data-file='"+f.name+"' class='selProductFile' title='Click to remove'></a>";
                   $(".imgs_wrap").append(html);
                  //  $(".imgs_wrap").append("<img src=\"" + e.target.result + "\" data-image='"+f.name+"' class='"+f.name+"' onclick=\"deleteImageAction("+index+")\" id=\"img_id_"+index+"\"><input id=\"img_id"+index+"\" type=text name='tmpfile[]' value=\"" + e.target.result + "\" class='"+f.name+"'> ")
                   index++;
               }
               reader.readAsDataURL(f);
               //document.getElementById('count').val() = sel_files.length;
               //$(".count").html(sel_files.length);
           });
       }

     /*
       function deleteImageAction(index) {
           console.log("index : "+index);
           console.log("sel length : "+sel_files.length);

           sel_files.splice(index, 1);

          // var img = "#img_id"+index;
          // $(img).remove();

           var img_id = "#img_id_"+index;
           $(img_id).remove();
           //sel_files.length = sel_files.length - 1;

       }
       */

       function fileUploadAction() {
           console.log("fileUploadAction");
           $("#input_imgs").trigger('click');
       }

       function submitAction() {
           console.log("업로드 파일 갯수 : "+sel_files.length);
           var data = new FormData();

           for(var i=0, len=sel_files.length; i<len; i++) {
               var name = "image_"+i;
               data.append(name, sel_files[i]);
           }
           data.append("count", sel_files.length);

           /*
           if(sel_files.length < 1) {
               alert("한개이상의 파일을 선택해주세요.");
               return;
           }
           */
           var xhr = new XMLHttpRequest();
           xhr.open("POST","free_board_write_db.php",true);
           xhr.onload = function(e) {
               if(this.status == 200) {
                   console.log("Result : "+e.currentTarget.responseText);
               }
           }
           xhr.send(data);

          //document.getElementById('count').val() = sel_files.length;
          //alert(sel_files.length);
       }

   </script>


<!--
   <script type="text/javascript">

   $(document).ready(function(){

       $("#submitBtn").click(function(){   // allBtn 버튼을 누르면 post 방식으로 all_user.php 에 데이터를 보냄
           $.post("free_board_modify_db.php",{
               count:$(".count").val(),
               },
               function(data,success){
                  if(success=="success"){
                    alert('성공');
                    //$(".table").html(data);
                    //$(".table").removeClass(".table-bordered");
                   // alert("데이터 5개씩 정렬");
                  }else{
                    alert("실패");
                 }
                });
              });

              });
   </script>
 -->


   <div class="input_wrap">

      <a href="javascript:" onclick="fileUploadAction();" class="btn btn-primary"><strong>이미지 올리기</strong></a>

       <input type="file" id="input_imgs" name="userfile[]" multiple/>
   </div>

   <!--
<hr align="center" style="width:100%">
-->
<div>
   <div class="imgs_wrap">
       <img id="img" />
   </div>
</div>

    <!-- <center>
     <input type="button" value="추가" onclick="attachFile.add()" style="margin-left:5px; margin-bottom:10px">
     <div id="attachFileDiv" style="margin-left:5px; background:yellow;"></div></center>
     <div id="imgdiv" style="width: 50px; height:50px; background:blue;"></div>
-->

  </div>
</div>
<!-- 사진등록 끝지점-->

<br>

    <br>
    <center>

      <input id="submitBtn" type="submit" class="btn btn-outline-primary" value="작성완료" style="width:80%; height:50px;margin-left:auto;margin-right:auto">
<!--
      <a href="javascript:" type="submit" onclick="submitAction();">
     <input id="submitBtn" type="submit" class="btn btn-outline-primary" value="작성완료" style="width:800px; height:50px;margin-left:50px;">
   </a>
 -->
 </center>

        </form>
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
