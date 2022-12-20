<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contacts";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if (!$conn) {
  die("connection failed").mysqli_connect_error();
} 
session_start();

if (isset($_POST["signup"])){ 
	$name= $_POST['name'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	$ENTER = "SELECT * FROM user_login WHERE name='$name'";
	$result = mysqli_query($conn, $ENTER);

	if(!$result->num_rows > 0 ){
		$ENTER = "INSERT INTO user_login(name,email,password) values('$name','$email' ,'$password')";
	$result= mysqli_query($conn,$ENTER);
		echo mysqli_error($conn);
	if ($result){	
	
		echo "<script>alert('User Registration Completed.')</script>";
	}
}
	else {
			echo "<script>alert('Sorry, Username Already Exists.')</script>";
		}
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card">
    <div class="card-body register-card-body">
      <h4 class="login-box-msg"><strong> Register a New Account </strong></h4>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye"  onclick="myFunction()" ></span>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" name="signup" class="btn btn-primary btn-block">Register</button>
          </div>
          </div>
      </form>
<br><a href="login.php" class="text-center">I already have an account? Log in</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
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