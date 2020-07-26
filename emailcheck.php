

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
 $email=$_POST['useremail'];

if ($email=='') {

?>
			    <font style="color:black">ex) abcd@google.com</font>
<?php
} else {


 if(preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i',$email) == false) {

  ?>
 <font style="color:red">이메일형식을 지켜주세요</font>
  <?php

} else {

	if($email != NULL){
	$email_check = mq("select * from member where email='{$_POST['useremail']}'");
	$email_check = $email_check->fetch_array();

	if($email_check >= 1){
		?>
		 <font style="color:red">이메일중복</font>
  <?php
	} else {
		?>
<font style="color:green">사용가능</font>
		<?php

	       }
                   }
        }
			}       ?>
