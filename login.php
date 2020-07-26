<?php

session_start();

if (empty($_COOKIE['check'])) {   // 쿠키가 삭제되었다면
    unset($_SESSION['cookie']);
}

//echo $_COOKIE['check'];
//echo $_SESSION['cookie'];

 ?>

<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>진실의방</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript">


    $(document).ready(function(){

    // 저장된 쿠키값을 가져와서 이메일 칸에 넣어준다. 없으면 공백으로 들어감.
    var key = getCookie("check");
    // var value = $("#uemail").val();

   //  $("#uemail").val(key);

    if($("#uemail").val() != ""){ // 그 전에 email 을 저장해서 입력 칸에 저장된 email 표시된 상태라면,
       $("#emailSave").attr("checked", true); // email 저장하기를 체크 상태로 두기.
    }

    $("#emailSave").change(function(){ // 체크박스에 변화가 있다면,
       if($("#emailSave").is(":checked")){ // email 저장하기 체크했을 때,
            setCookie("check","checked", 7); // 7일 동안 쿠키 보관
           //setCookie("key", $("#uemail").val(), 7); // 7일 동안 쿠키 보관
       }else{ // email 저장하기 체크 해제 시,
           deleteCookie("check");
       }
    });

    // email저장하기를 체크한 상태에서 email를 입력하는 경우, 이럴 때도 쿠키 저장.
    $("#uemail").keyup(function(){ // email 입력 칸에 email를 입력할 때,
       if($("#emailSave").is(":checked")){ // email 저장하기를 체크한 상태라면,
           setCookie("check","checked", 7); // 7일 동안 쿠키 보관
       }
    });
    });

    function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
    }

    function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
    }

    function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
       start += cookieName.length;
       var end = cookieData.indexOf(';', start);
       if(end == -1)end = cookieData.length;
       cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
    }


    </script>
  </head>

  <body cellpadding="0" cellspacing="0" marginleft="0" margintop="0" width="100%" height="100%" align="center">
<br><br><br>

	<div class="card align-middle" style="width:20rem; margin: 0 auto; border-radius:20px;">
		<div class="card-title" style="margin-top:30px;">
			<h2 class="card-title text-center" style="color:#113366;">진실의방</h2>
		</div>
		<div class="card-body">
      <form class="form-signin" method="POST" action="login_ok.php">
        <h4 class="form-signin-heading text-center">로그인</h4><br>
        <label for="inputEmail" class="sr-only">Email</label>
        <?php
         if (isset($_SESSION['cookie'])) {
           ?>
<input type="email" id="uemail" name="email" class="form-control" value="<?php echo $_SESSION['cookie']; ?>" required autofocus><br>
           <?php
         } else {
          ?>
        <input type="email" id="uemail" name="email" class="form-control" placeholder="Email" required autofocus><br>
          <?php
         }

         ?>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="upw" name="password" class="form-control" placeholder="Password" required><br>
        <div class="checkbox">
          <label>
            <input type="checkbox" id="emailSave"> 이메일저장
          </label>
        </div>
        <button id="btn-Yes" class="btn btn-lg btn-primary btn-block" type="submit">로 그 인</button>
      </form>

		</div>
	</div>


	<div class="modal">
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
