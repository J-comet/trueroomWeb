<?php
session_start();

//echo "인증코드 : ".$_SESSION['code'];

 ?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>진실의방</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<script type="text/javascript">
$(document).ready(function(e) {
  $(".check").on("keyup", function(){ //check라는 클래스에 입력을 감지
    var self = $(this);
    var useremail;

    if(self.attr("id") === "useremail"){
      useremail = self.val();
    }

    $.post( //post방식으로 id_check에 입력한 userid값을 넘깁니다
      "verify_emailcheck.php",
      { useremail : useremail },
      function(data){
        if(data){ //만약 data값이 전송되면
          $('.chk_email').html(data);
          //self.parent().parent().find("div").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
          //self.parent().parent().find("div");
        }
      }
    );
  });
});
</script>

  </head>

  <body>




<br><br><br>
<div class="card" style="margin: 0 auto; width:50%; height:100%;">

<center><h1 style="margin-top:50px;">진실의방 기업회원 인증</h1></center>

<form class="" action="email_code_send.php" method="post">

<div style="width:349px; margin-left:200px; margin-top: 50px;">
  <p style="margin:0; color:gray; font-size:13px;">*개인이메일 가입 불가능</p>

  <?php
    if (empty($_COOKIE['verify_code'])) {   // 쿠키의 만료시간이 다되어서 없어지거나 삭제되면
      unset($_SESSION['code']);      // 세션에 저장되어있는 인증코드 삭제
      unset($_SESSION['email']);  // 세션에 저장되어있는 이메일도 삭제

    }

   ?>


<?php
  // 메일전송이 성공적으로 보내지고 세션이 생겼다면
  if ($_SESSION['email']) {

    // db에 저장시킬 session 값
    $_SESSION['dbemail'] = $_SESSION['email'];


    ?>
    <input type="text" size="35" name="useremail" id="useremail" class="check" value="<?php echo $_SESSION['email']; ?>" style="margin:5px 0 3px 0;" readonly />
      <input type="submit" style="width:300px;margin-top:20px; margin-bottom:50px;margin-left:30px;" class="btn btn-primary" value="전송완료" disabled>

    <?php
  } else {
    ?>
    <input type="text" size="35" name="useremail" id="useremail" class="check" placeholder="이메일"  style="margin:5px 0 3px 0;" required />
      <div id="id_check" class="chk_email" style="font-size:14px; float:right">ex) abcd@domain.com</div>
      <input type="submit" style="width:300px;margin-top:20px; margin-bottom:50px;margin-left:30px;" class="btn btn-outline-primary" value="인증코드전송">

    <?php
  }
  ?>

</div>

</form>

<?php if (isset($_COOKIE['verify_code'])) {   // 메시지전송이 성공적으로 보내져서 쿠키가 생성되었다면 타이머실행
  ?>
  <script>

		var SetTime = 60;		// 최초 설정 시간  - 쿠키 만료시간과 동일해야됨

		function msg_time() {	// 1초씩 카운트해줄 함수

			m = Math.floor(SetTime / 60) + "분 " + (SetTime % 60) + "초";	// 남은 시간 계산
			var msg = "<font color='red'>유효시간 " + m + "</font>";
			document.all.timer.innerHTML = msg;		// div 영역에 보여줌
			SetTime--;					// 1초씩 감소

			if (SetTime < 0) {			// 시간이 종료되었을 때
				clearInterval(tid);		// 타이머 해제  setInterval() 함수로 반복되는 것을 멈추게해줌
      //  clearInterval(check_cookie);
				alert("인증코드 유효시간 만료");
        location.replace("verify_email.php");   // 인증코드 유효시간이 만료되었다면 페이지 리로딩
			}

		}

		window.onload = function TimerStart(){
      tid = setInterval('msg_time()',1000);  // 일정시간후 함수를 실행시키는 setInterval() 함수를 이용해서 1초마다 msg_time() 을 실행
     };



	</script>
  <?php
}
?>

<div id="timer" class="Timer" style="margin-left:220px; margin-bottom:20px;"></div>

<script>

function deleteCookie(cookieName){  // 쿠키값 삭제 해주는 함수
var expireDate = new Date();
expireDate.setDate(expireDate.getDate() - 1);  // 어제날짜로 만료기간을 바꿈
document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}


var hit_cnt = 0; // 인증버튼 누른횟수 값

function verifyCheckFunction() {   // 인증코드 확인해주는 함수

      var input_code = $('#input_code').val();  // 사용자가 입력한 코드 값
      var hidden_code = $('#hidden_code').val();   // 히든으로 서버에 저장된 코드값

     if (input_code == hidden_code) {

       //$('.successVerify').html('인증이 완료되었습니다');
       //$('.verifyMsg').html('재직했었던 것을 증명할 수 있는 사진을 제출해주세요');
       clearInterval(tid);  // 타이머 멈춤
       $('.Timer').css('display','none');

       deleteCookie("verify_code");  // 쿠키삭제
       alert('인증성공');
        location.replace('signup_workman.php');

      } else {

        hit_cnt++;

        if (hit_cnt == 3 ) {
          alert('다시 시도해주세요');

          deleteCookie("verify_code");  // 쿠키삭제

          location.reload();
        } else {
          alert('인증실패');
        }
      //  $('#passwordCheckMessage').css('color','red').html('비밀번호 불일치');
      }

}
</script>

<div style="margin-left:250px; margin-bottom:50px;">
<p style="margin:0">인증코드</p>
<?php
if ($_SESSION['code']) {   // 세션의 코드가 아직 저장되어있다면

  ?>

  <input style="margin:5px 0 10px 0;" id="input_code" type="password" size="25" name="password" required>
  <input type="hidden" id="hidden_code" name="code" value="<?php echo $_SESSION['code']; ?>">
  <br>
  <input style="width:255px;" type="button" name="" class="btn btn-outline-success" value="확인" onclick="verifyCheckFunction();">

  <?php
} else {
  ?>
  <input style="margin:5px 0 10px 0;" type="password" size="25" name="password" required><br>
  <input style="width:255px;" type="button" name="code" class="btn btn-outline-success" onclick="alert('유효한 인증코드가 없습니다')" value="확인">
  <?php
}

 ?>

</div>

</div>
  </body>
</html>
