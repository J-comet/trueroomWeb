<?php

//$question_idx = $_GET['idx'];

 //echo "include : ".$question_idx;

  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query ="UPDATE admin_question SET question_status='1', admin_answer='$admin_answer' WHERE idx = '$question_idx'";
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐

  $result = $connect->query($query);


if (isset($result)) {
echo "<script>
  alert('문의처리');
  history.back();
</script>";
} else {
  echo "<script>
    alert('처리실패');
    history.back();
  </script>";
}


/*
if (empty($question_idx)) {
  echo "<script>
    alert('잘못된접근입니다');
    history.back();
  </script>";
} else {

  $connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

  $query ="UPDATE admin_question SET question_status='1' WHERE idx = '$question_idx'";
  mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨짐

  $result = $connect->query($query);
}

if ($result) {
echo "<script>
  alert('문의처리');
  history.back();
</script>";
} else {
  echo "<script>
    alert('처리실패');
    history.back();
  </script>";
}
*/

 ?>
