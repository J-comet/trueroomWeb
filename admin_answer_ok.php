<?php

 session_start();
 //header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$question_idx = $_POST['idx'];  // 관리자문의 idx
$title = $_POST['title'];  // 문의 제목
$content = $_POST['content'];  // 문의 내용
$date = $_POST['date']; // 문의 날짜

$admin_answer= $_POST['admin_answer'];  // 관리자 답변
$receiver_email = $_POST['receiver_email'];  // 전달받을 이메일

 include('mail/PHPMailerAutoload.php');


 $send_content = "안녕하세요.
 진실의방 관리자입니다.
 귀하께서 ";

 $send_content .= $date;

 $send_content .= "에 문의 해주신

 제목 : ";

 $send_content .= $title;

 $send_content .= "

 내용 : ";

 $send_content .= "$content";

 $send_content .= "
 
 에 대한 답변입니다.

 답변 : ";

 $send_content .= $admin_answer;

 $send_content = nl2br($send_content);

/*
echo $question_idx."<br>";
echo $title."<br>";
echo $content."<br>";
echo $date."<br>";
echo $admin_answer."<br>";
echo $receiver_email."<br>";
*/


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

       // 함수안에서 선언 해줘야 함수안에 값이 저장됨

       $question_idx = $_POST['idx'];  // 관리자문의 idx
       $admin_answer= $_POST['admin_answer'];  // 관리자 답변


       if ( $mail->send() ) {  // 이메일보내는 것 성공하면 db 업데이트 시켜주기

         include('true_admin_question_completed.php');
       ?>

       <!--
       <script type="text/javascript">
          alert('요청처리완료');
          location.href = "true_admin_question_completed.php?idx="+<?php $question_idx; ?>;
          //location.href='true_admin_question_completed.php?idx='+<?php echo $question_idx; ?>;
       </script>
     -->
       <?php
         /*
         $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");
         $query ="UPDATE admin_question SET question_status='1' WHERE idx = '$question_idx'";
         mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐

         $result = $connect->query($query);

         if ($result) {  // db 업데이트 성공시 돌아감
          ?>
          <script type="text/javascript">
             //alert('요청처리완료');
             location.replace('admin_question_ok.php');
          </script>
          <?php
        } else {   // db 업데이트 실패
          ?>
          <script type="text/javascript">
             alert('업데이트실패');
             history.back();
          </script>
          <?php
        } */
       ?>

       <?php
       }
       else {   // 이메일전송 실패 했을 때
         echo "<script>
           alert('전송실패');
           history.back();
         </script>";
       }
 }

 mailer("진실의방","zarox3@naver.com",$receiver_email,"문의 답변",$send_content,1);

 ?>

 <!DOCTYPE html>
 <html lang="ko" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>

   </body>
 </html>
