
<?php

$email = $_SESSION['useremail'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die("fail");

$query = "SELECT * FROM member WHERE email ='{$email}'"; // email 로 해당 email 찾음

$res = mysqli_query($connect,$query);
mysqli_query($connect,"set names utf8");   // set names utf8 을 붙히지 않으면 한글이 깨져서 저장됨
$res = $connect->query($query);
if($res->num_rows >= 1) {

  $row = mysqli_fetch_array($res);

    $member_idx = $row['idx'];
  //$name = $row['name'];
  //$admin = $row['admin'];
  //$favorite_place = $row['favorite_place'];
  //$favorite_job = $row['favorite_job'];

//  $account_pause = $row['account_pause'];

}

//echo $member_idx;

$uploaddir = $_SERVER['DOCUMENT_ROOT']."/upload/";
//$uploaddir = "/uploads/";
echo "<br>";
print_r($uploadfile = $uploaddir.basename($_FILES['userfile']['name']));

//echo "<br>";

$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
//print_r($_FILES['userfile']['name']); // 사용자가 선택한 파일명이 나옴

//$uploadfile = $uploaddir.date("YmdHis");

//echo "<br>";
//$imageurl = "uploads/" . $_FILES['userfile']['name']; // 파일명을 변수에 저장

//$imageurl = "upload/" . date("YmdHis"); // 파일명을 변수에 저장


//파일의 확장자명을 저장
// strtolower 를 사용하면 소문자로만 저장 , strtoupper 를 사용하면 대문자로만 저장
$imageFileType = pathinfo($uploadfile,PATHINFO_EXTENSION);

$imageurl = "upload/". $member_idx ."-". date("YmdHis").".".$imageFileType; // 파일명을 변수에 저장

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    echo "
    <script>
      alert('이미지만 업로드 가능');
      history.back();
    </script>";
}
// Check file size
else if ($_FILES["userfile"]["size"] > 500000) {
    //echo "Sorry, your file is too large.";
    echo "
    <script>
      alert('500KB 이하만 가능');
      history.back();
    </script>";
}

else if (move_uploaded_file($_FILES['userfile']['tmp_name'], $imageurl)) {
echo "파일업로드 성공.\n";
//$imageurl = "uploads/" . $_FILES['userfile']['name']; // 파일명을 변수에 저장

$imageurl = "upload/". $member_idx ."-". date("YmdHis").".".$imageFileType; // 파일명을 변수에 저장

} else {
  "<script>
      alert('이미지 업로드에 실패하였습니다');
      history.back();
    </script>";
}

echo 'info:';
print_r($_FILES);
echo "<br />";

if(UPLOAD_ERR_OK !=$_FILES['userfile']['error'])
{

switch ($_FILES['userfile']['error']) {
case UPLOAD_ERR_INI_SIZE:
$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
break;
case UPLOAD_ERR_FORM_SIZE:
$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
break;
case UPLOAD_ERR_PARTIAL:
$message = "The uploaded file was only partially uploaded";
break;
case UPLOAD_ERR_NO_FILE:
$message = "No file was uploaded";
break;
case UPLOAD_ERR_NO_TMP_DIR:
$message = "Missing a temporary folder";
break;
case UPLOAD_ERR_CANT_WRITE:
$message = "Failed to write file to disk";
break;
case UPLOAD_ERR_EXTENSION:
$message = "File upload stopped by extension";
break;
default:
$message = "Unknown upload error";
break;
}

//echo $message;

}
//print "</pre>";
?>
