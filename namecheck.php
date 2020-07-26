

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
 $name=$_POST['username'];

if ($name=='') {

?>
			    <font style="color:black">한글만 가능</font>
<?php
} else {


 if(preg_match('/^[가-힣]+$/',$name) == false) {

  ?>
 <font style="color:red">한글만 가능</font>
  <?php

} else {

	if($name != NULL){
	$name_check = mq("select * from member where name='{$_POST['username']}'");
	$name_check = $name_check->fetch_array();

	if($name_check >= 1){
		?>
		 <font style="color:red">닉네임중복</font>
  <?php
	} else {
		?>
<font style="color:green">사용가능</font>
		<?php

	       }
                   }
        }
			}       ?>
