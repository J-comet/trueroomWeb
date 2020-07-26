<?php

  session_start();
  
  unset($_SESSION['useremail']);
	//session_destroy();
?>

<script>
alert("로그아웃되었습니다.");
location.replace('index.php');
//history.go(-1);
</script>

<meta charset="utf-8">
<meta http-equiv="refresh" content="0;/>
