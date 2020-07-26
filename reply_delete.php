<?php

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$board_idx = $_GET['idx'];
$board_title = $_GET['title'];

$reply_idx = $_GET['reply_idx']; // 댓글의 고유 idx 값

//echo $reply_idx."<br>";

$bno =$_POST['chk_delete'];  // POST 방식으로 넘어온 값을 받음. 내가쓴 댓글 목록에서 삭제할 때 받는 데이터

$bno_implode = implode(',',$bno);  // 배열을 한 문자열로 만들어주는 implode 사용
$bno_explode = explode(',',$bno_implode);  // 문자열을 ',' 을 기준으로 나누어주는 explode 사용

$bno_count = count($bno_explode); // 배열의 개수 구하는 count 사용


if (strlen($board_idx) > 0) { // 넘어온 데이터가 있다면

$query = "DELETE FROM reply WHERE idx ='{$reply_idx}'"; // idx 로 해당게시물을 찾음

$result = mysqli_query($connect,$query);

if (isset($result)){

?>
   <script>
  alert('삭제완료');
  // 삭제후 게시물로 돌아감
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
} else {
  ?>
  <script>
  alert('삭제실패');
  location.replace("free_board_view.php?idx=<?php echo $board_idx; ?>&title=<?php echo $board_title; ?>");
  </script>
<?php
  }
}

else {

    if (strlen($bno_implode) < 1) {  // 넘어온 데이터 문자열 길이로 데이터가 있는지 판별
      ?>
      <script type="text/javascript">
      alert('삭제할 글을 선택해주세요');
      history.back();
      </script>
      <?php
    } else {

      // 배열 개수만큼 반복해서 쿼리문을 실행
      for ($i=0; $i < $bno_count ; $i++) {

         $query = "DELETE FROM reply WHERE idx ='$bno_explode[$i]'"; // idx 로 해당게시물을 찾음

         $result = mysqli_query($connect,$query);
      }

      if (isset($result)){

      ?>
         <script>
        alert('삭제완료');
        history.back();
        </script>
      <?php
      } else {
        ?>
        <script>
        alert('삭제실패');
        history.back();
        </script>
      <?php
      }
    }
  }
 ?>
