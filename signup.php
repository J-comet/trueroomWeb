


 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="utf-8" />
 <title>진실의방 회원가입</title>


 <link href="css/signup.css" rel="stylesheet">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

 <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
 <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script>

 $(document).ready(function(e) {
 	$(".check").on("keyup", function(){ //check라는 클래스에 입력을 감지
 		var self = $(this);
 		var useremail;

 		if(self.attr("id") === "useremail"){
 			useremail = self.val();
 		}

 		$.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
 			"emailcheck.php",
 			{ useremail : useremail },
 			function(data){
 				if(data){ //만약 data값이 전송되면
 					self.parent().parent().find("div").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
 					//self.parent().parent().find("div"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
 				}
 			}
 		);
 	});
 });


 $(document).ready(function(e) {
 	$(".check_name").on("keyup", function(){ //check라는 클래스에 입력을 감지
 		var self = $(this);
 		var username;

 		if(self.attr("id") === "username"){
 			username = self.val();
 		}

 		$.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
 			"namecheck.php",
 			{ username : username },
 			function(data){
 				if(data){ //만약 data값이 전송되면
 					self.parent().parent().find("div").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
 					//self.parent().parent().find("div"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
 				}
 			}
 		);
 	});
 });

function password1(){

  var userpassword = $('#password').val();
  var check = /^(?=.*[a-zA-Z])(?=.*[0-9]).{8,16}$/.test(userpassword);   //영문,숫자

if (userpassword=='') {
    $('#passwordmsg').css('color','black').html('영문,숫자조합으로 8~16자 입력');
} else {

  if (!check){
      $('#passwordmsg').css('color','red').html('비밀번호형식을 지켜주세요');
  } else {
      $('#passwordmsg').css('color','green').html('사용가능');
  }
 }
}

function passwordCheckFunction() {

      var userpassword = $('#password').val();
      var userpassword2 = $('#passwordCheck').val();


      if (userpassword2=='') {
          $('#passwordCheckMessage').css('color','black').html('');
      } else {

     if (userpassword == userpassword2) {
        $('#passwordCheckMessage').css('color','green').html('비밀번호 일치');

      } else {
        $('#passwordCheckMessage').css('color','red').html('비밀번호 불일치');
      }
 }
}




 </script>

 </head>

 <body cellpadding="0" cellspacing="0" marginleft="0" margintop="0" width="100%" height="100%" align="center">
<br><br><br>

   <div class="card align-middle" style="width:50rem; margin: 0 auto; margin-top: 10px;  margin-bottom: 50px; border-radius:20px;">
     <div class="card-title" style="margin-top:30px;">
       <h2 class="card-title text-center" style="color:#113366;">진실의방</h2>
     </div>

     	<div class="card-body">
 	<form method="post" action="signup_ok.php" name="memform" class="signup-form">
  <h5 class="form-signin-heading text-center" style="margin:0;">일반회원</h5>
<hr style="width:100%;"> <br>
 					<table style="margin-left:180px;">
 						<tr style="margin-bottom:7px;">
 							<td>이메일</td>
              </tr>
              <tr>
 							<td>
                <input type="text" size="35" name="useremail" id="useremail" class="check" placeholder="이메일"  style="margin:5px 0 10px 0;" required />&nbsp&nbsp</td>
                 <td><div id="id_check" style="font-size:13px;">ex) abcd@google.com</div></td>
 							</td>
 						</tr>

 						<tr>
 							<td>비밀번호</td>
            </tr>
            <tr>
 							<td><input style="margin:5px 0 10px 0;" class="pwcheck" id="password" type="password" size="35" name="password" onkeyup="password1();" placeholder="비밀번호" required>&nbsp&nbsp</td>
             <td><div id="passwordmsg" style="font-size:13px;">영문,숫자조합으로 8~16자 입력</div></td>
            </tr>
            <tr>
              <td>비밀번호 확인</td>
            </tr>
            <tr>
              <td><input style="margin:5px 0 10px 0;" id="passwordCheck" type="password" size="35" name="pwCheck" onkeyup="passwordCheckFunction();" placeholder="비밀번호 확인" required>&nbsp&nbsp</td>
                 <td><div id="passwordCheckMessage" style="font-size:13px;"></div></td>
            </tr>
 						<tr>
 							<td>닉네임</td>
            </tr>
            <tr>
 							<td><input maxlength="6" style="margin:5px 0 10px 0;" id="username" class="check_name" type="text" size="35" name="username" placeholder="닉네임" required></td>
              <td><div id="nameCheckMessage" style="font-size:13px;"></div></td>
 						</tr>

            <tr>
 							<td>성별</td>
            </tr>
            <tr>
 							<td><input type="radio" id="gender1" name="gender" value="남자" style="margin:5px 0 10px 0;"checked><label for="gender1">남자</label>
                <input type="radio" id="gender2" name="gender" value="여자" style="margin:5px 0 10px 0;"><label for="gender2">여자</label>

              </td>

 						</tr>

            <tr>
              <td>
                <div style="margin-top:10px;">
                관심지역
              </div></td>
            </tr>
            <tr>
              <td>
                <div>
                  <select name="favorite_place" style="width:340px;height:38px;" required>

                    <option value="">&nbsp&nbsp관심지역</option>
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

              </td>
            </tr>

            <tr>
              <td>
                <div style="margin-top:14px;">
                관심직종
              </div></td>
            </tr>
            <tr>
              <td>
                <div>
                  <select name="favorite_job" style="width:340px;height:38px;" required>

                    <option value="">&nbsp&nbsp관심직종</option>
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

              </td>
            </tr>

 					</table>
          <br><br>
  <center><input class="btn btn-outline-primary" style="width:400px; height:50px;" type="submit" value="가입하기"/></center>
 	</form>

</div>
</div>

 </body>
 </html>
