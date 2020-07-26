
<div style="width:21.3%; margin-left: 3%; height:35%;">


<div style="width:21.3%; margin-left: 3%; height:55%;">

 <!-- <img src="image/user.png" class="card-img-top img-fluid" style="width:25px; height:25px;"> -->
   <div class="card">

         <div class="card-body" style="width:100%; height:100%;">
           <p style="margin: 27% 0 27% 16.5%;font-weight:bold; font-size:100%;">작성된 게시글이 없습니다</p>
         </div>

     </div>
   </div>


<?php

session_start();
$email = $_POST['email'];
$password = $_POST['password'];

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom");


// 아이디가 있는지 검사
$query = "select * from member where email='$email'";
$result = $connect->query($query);

//아이디가있다면 비밀번호 검사
if (mysqli_num_rows($result)==1) {
     $row=mysqli_fetch_assoc($result);

     //비밀번호가 맞다면 세션 생성
     if ($row['password']==$password) {
       $_SESSION['useremail']=$email;
       if (isset($_SESSION['useremail'])) {
         echo "Yes";
      } else {
        echo "No";
      }

}
}
/*
if (isset($email)) {
  $query ="SELECT * FROM member WHERE email ='$email' AND password = '$password'";

   $result = mysqli_query($connect,$query);

   if (mysqli_num_rows($result) > 0) {
           $_SESSION['useremail'] = $email;
           echo "True";
   } else {
     echo "No";
   }
}
*/
/*
session_start();

$connect = mysqli_connect("localhost","root","gptjd7848","trueroom") or die ("fail");
$email = $_POST['email'];
$password = $_POST['password'];
*/


 ?>
