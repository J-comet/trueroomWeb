<?php
header("Content-Type: text/html; charset=UTF-8");

//파일이 저장될 경로
$target_dir ="upload/";

//업로드한 파일의 총 수를 구한다.
$total = count($_FILES["userfile"]["name"]);

//$total = count($_FILES["tmpfile"]["name"]);

$arr_image= array();  // 이미지를 담을 배열을 선언


     //업로드된 파일 수만큼 반복문을 진행
  //  for ($i=0; $i < $total ; $i++) {
    for ($i=0; $i < $total; $i++) {
        $date = date("YmdHis")."-";

      //파일이 저장될 경로 및 확장자명이 포함된 파일 이름을 저장한다.
       $target_file = $target_dir . basename("(".$idx.")-".$i."-".$date.$_FILES['userfile']["name"][$i]);

      array_push($arr_image,$target_file);  // 배열에 값 추가
      $arr_image_cnt = count($arr_image);   // 배열에 값이 있는지 확인하기 위해 카운트
      //파일의 확장자명을 저장
      // strtolower 를 사용하면 소문자로만 저장 , strtoupper 를 사용하면 대문자로만 저장
      $ext = pathinfo($target_file,PATHINFO_EXTENSION);

        /*  현재 free_board_write.php 에서 이미지 파일만 올릴 수 있도록 바로 검사를 했기 때문에 주석처리
        // Allow certain file formats
        if($ext != "jpg" && $ext !="JPG" && $ext != "png" && $ext != "PNG" && $ext != "jpeg" && $ext != "JPEG" && $ext != "gif" && $ext != "GIF") {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            echo "
            <script>
              alert('$arr_image_cnt');
              history.go(-2);
            </script>";
        }
        */

      //파일의 이름을 저장
      //확장자가 대문자인데, $ext 에 담긴 확장자는 소문자라면 확장자가 제거 되지 않은 이름이 저장된다.
      $filename = basename($target_file,".$date");


      //중복된 파일이 존재할 경우 1을 붙여줄 것이다. ex) /uploads/test(1).text
      $num = 1;
      //같은 확장자 및 같은 이름을 지닌 파일이 이미 존재할경우
      if (file_exists($filename)) {

        // 같은 확장자 및 같은 이름을 지닌 파일이 없을때까지 반복
        while (file_exists($filename)) {

        // 같은 이름의 파일이 있다면 파일명을 변경해준다 ex)  /uploads/test.text 에서 /uploads/test(1).text 로 바꿈
        $filename2 = $filename."($num)";

        //변경한 파일명을 저장해준다
        $filename = $target_dir.$filename2.".$ext";

        //같은 이름의 파일이 존재하는한 num은 1씩 증가하며, 파일의 이름을 변경해주는데 쓰인다
        $num++;
        }
      } else {

        if (move_uploaded_file($_FILES['userfile']["tmp_name"][$i],$target_file)) {
              //파일이 업로드에 성공하였을 때
          $size = filesize($target_file);

          if ($size > pow(1024,3)) {
             $size = round($size/(pow(1024,3)),2)."GB";
          }
          if ($size > pow(1024,2)) {
             $size = round($size/(pow(1024,2)),2)."MB";
          }
          if ($size > pow(1024,1)) {
             $size = round($size/(pow(1024,1)),2)."KB";
          }

          //echo "다운로드 : <a href='download.php?filepath=".$target_file."&filename=".$filename.".$ext'>".$filename.".$ext"."</a> (".$size.")<br>";
          //$image = htmlspecialchars($target_file);
          //echo "타겟파일 :".$filename."<br>";
          //echo "이미지 :".$target_file."<br>";
          ?>

        <!--  <img src="<?php echo $target_file; ?>">  -->
          <?php
        } else {
          // 이미지를 올리지 않았을 경우 배열이였던 $arr_image 를 "-" 로 만들면서 값이 없게 만든다
          $arr_image = "-";
          //echo "업로드를 실패하였습니다.<br>";
        }
      }

 }
 ?>
