

<script type="text/javascript">

function setCookie(cookieName, value, exdays){  // 쿠키 생성 함수
var exdate = new Date();
exdate.setTime(exdate.getTime() + exdays * 1000 );
var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
document.cookie = cookieName + "=" + cookieValue;
}

</script>

<?php

session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","gptjd7848","trueroom");
$db->set_charset("utf8");

function mq($sql)
{
  global $db;
  return $db->query($sql);
}


include('mail/PHPMailerAutoload.php');


// 랜덤 글자 생성
function randomString($length = 6){
  $characters = '0123456789abcdefghizklmnopqrstuvwxyzABCDEFGHIJKLIMOPQRSTUVWXYZ';   // 이 글자중에서 랜덤으로 6글자 생성
  $charLength = strlen($characters);
  $verify_value = '';
  for ($i=0; $i < $length ; $i++) {  // length 만큼 반복
     $verify_value .= $characters[rand(0,$charLength - 1)];
  }
  return $verify_value;
}

$code = randomString();



$inputemail = $_POST['useremail']; // 유저가 입력한 이메일을 verify_email.php 에서 받음

$domain = explode('@',$inputemail); // @ 로 문자열을 자름 , 배열로 저장됨
$domain_cnt = count($domain);  // 배열크기를가져옴

//echo $inputemail;
//echo $code;

$_SESSION['code'] = $code;  // 성공적으로 메일 보냈을 때 인증코드 세션 생성
$_SESSION['email'] = $inputemail;  // 성공적으로 메일 보냈을 때 이메일 세션 생성

$send_content = "진실의방 사이트입니다^^

인증을 완료해주세요

[인증코드]
";
$send_content .= $code;

$send_content = nl2br($send_content);

function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="")
{
      if ($type != 1) $content = nl2br($content);
      // type : text=0, html=1, text+html=2
      $mail = new PHPMailer(); // defaults to using php "mail()"
      $mail->IsSMTP();
         //   $mail->SMTPDebug = 2;
      $mail->SMTPSecure = "ssl";
      $mail->SMTPAuth = true;
      $mail->Host = "smtp.naver.com";
      $mail->Port = 465;
      $mail->Username = "zarox3";
      $mail->Password = "janghyeseong23";
      $mail->CharSet = 'UTF-8';
      $mail->From = $fmail;
      $mail->FromName = $fname;
      $mail->Subject = $subject;
      $mail->AltBody = ""; // optional, comment out and test
      $mail->msgHTML($content);
      $mail->addAddress($to);
      if ($cc)
            $mail->addCC($cc);
      if ($bcc)
            $mail->addBCC($bcc);
      if ($file != "") {
            foreach ($file as $f) {
                  $mail->addAttachment($f['path'], $f['name']);
            }
      }

      $inputemail = $_POST['useremail']; // 유저가 입력한 이메일을 verify_email.php 에서 받음

      $domain = explode('@',$inputemail); // @ 로 문자열을 자름 , 배열로 저장됨
      $domain_cnt = count($domain);  // 배열크기를가져옴

      $email_check = mq("select * from member where email='{$inputemail}'");
      $email_check = $email_check->fetch_array();

        for ($i=0; $i < $domain_cnt ; $i++) {
          if($domain[$i]=="naver.com"){
            ?>
            <script>
              alert('개인이메일은 사용불가능');
              history.back();
            </script>
            <?php

          } elseif ($domain[$i]=="gmail.com") {
           ?>
           <script>
             alert('개인이메일은 사용불가능');
             history.back();
           </script>
           <?php

         } elseif ($domain[$i]=="daum.net") {
           ?>
           <script>
             alert('개인이메일은 사용불가능');
             history.back();
           </script>
           <?php

         } elseif ($email_check >= 1)  {
           ?>
           <script>
             alert('중복이메일');
             history.back();
           </script>
           <?php
         }
       }


      if ( $mail->send() ) {

      ?>
      <script>
    function alertFunction(callback){
      alert('인증코드메일 발송');
      callback();
    }

    alertFunction(function(){   //  콜백함수를 사용해서 인증코드전송 확인창 버튼 눌렀을 때 쿠키 생성
      setCookie('verify_code', '1', 60); // 현재 60초 세팅  ( 나중에 3분으로 할 예정 )
      history.back();

      //location.replace('verify_email.php');
    });
    </script>
      <?php
      }
      else {
        echo "<script>
          alert('전송실패');
          history.back();
        </script>";
      }
}

mailer("진실의방","zarox3@naver.com",$inputemail,"인증코드발송",$send_content,1);

/*
if ($inputemail = '') {
  ?>
  <script>
    alert('이메일을 입력해주세요');
    history.back();
  </script>
  <?
} else {    // 입력한 이메일이 있다면

  $email_check = mq("select * from member where email='{$inputemail}'");
	$email_check = $email_check->fetch_array();

  for ($i=0; $i < $domain_cnt ; $i++) {
    if($domain[$i]=="naver.com"){
      ?>
      <script>
        alert('개인이메일은 사용불가능');
        history.back();
      </script>
      <?php

    } elseif ($domain[$i]=="gmail.com") {
     ?>
     <script>
       alert('개인이메일은 사용불가능');
       history.back();
     </script>
     <?php

   } elseif ($domain[$i]=="daum.net") {
     ?>
     <script>
       alert('개인이메일은 사용불가능');
       history.back();
     </script>
     <?php

   } elseif ($email_check >= 1)  {
     ?>
     <script>
       alert('중복이메일');
       history.back();
     </script>
     <?php
   }
   else
   {
     mailer("진실의방","zarox3@naver.com",$inputemail,"인증코드발송",$send_content,1);
   }
  }

  ?>
  <?php
}

//echo $_SERVER["REMOTE_ADDR"];
*/
?>
