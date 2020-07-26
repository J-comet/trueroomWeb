<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>진실의방</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  </head>
<style>

.contain{
  width: 100%;


}

.left{
  width: 50%;
  float: left;
  box-sizing: border-box;
}
.right{

  width: 50%;
  float: left;
  box-sizing: border-box;
}
.basic:hover{
  border: 2px solid #1263ce;
}
.work:hover{
  border: 2px solid #007a00;
}
</style>


  <body>
    <br><br><br>
<div style="width:75%; margin:0 auto;">

  <center><h1>진실의방</h1>
    <br><br><br>

  </center>

   <br><br>
<div class="contain">

<div class="left">

<center>

  <div class="basic card img-fluid bg-primary" style="width:55%; height:45%;">
    <a href="signup.php">
     <div class="card-img-overlay">
           <h2 class="card-title">일반회원</h2>
     </div>

 <img class="card-img-top" src="image/basicman.png" alt="Card image" style="align:right;width:71%;height:80%;margin-left:3%;margin-top:20%;margin-bottom:5%;">
</a>
</div>

</center>
</div>

<div class="right">
  <center>


  <div class="work card img-fluid bg-success" style="width:55%; height:45%;">
    <a href="verify_email.php">
    <div class="card-img-overlay">
      <h2 class="card-title">기업회원</h2>

    </div>
 <img class="card-img-top" src="image/workman.png" alt="Card image" style="width:80%;height:80%;margin-left:5%;margin-top:15%;">
</a>
</div>

</center>

</div>

</div>


</div>
  </body>
</html>
