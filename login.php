<?php
ini_set("display_errors", "1");
error_reporting(E_ALL); 
include 'config.php';

session_start();
error_reporting(0);

if(isset($_POST["login"])){
    $name2 = $_POST["name"];
    $password2 = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM user_login WHERE name = '$name2'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
      if($password2 == $row['password']){
        $_SESSION["login"] = true;
        $_SESSION["name"] = $row["name"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["id"] = $row["id"]; 
        $id = $_SESSION["id"];


        $create_table =$conn->query("CREATE TABLE IF NOT EXISTS  others_user_$id(id INT(80) NOT NULL AUTO_INCREMENT,contact_id  VARCHAR(80) NOT NULL,PRIMARY KEY(id))");
        header("Location:./home.php");

      }
      else{
        echo
        "<script> alert('Wrong Password'); </script>";
      }
    }
    else{
      echo
      "<script> alert('User Not Registered'); </script>";
    }
 }
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Log in</title>
 <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./all.min.css">
  <link rel="stylesheet" href="./adminlte.min.css">
</head>
</head>
<body class="hold-transition login-page">
<div id="content" class="p-4 p-md-5">

<div class="login-box">
  <div class="login-logo">
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
     <h4 class="login-box-msg"> <strong>Sign in to view your contacts</strong></h4>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" id="name" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name = "password" id ="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye"  onclick="myFunction()"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8"></div>
         
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Log In</button>
          </div>
         
        </div>

      </form>
      <h6 class="mb-0">Don't have an account?</h6>
      <a href="signup.php" style= "color: royalblue; "><h6> Sign Up </h6></a>
     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</div>





<script type="text/javascript">
  function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>