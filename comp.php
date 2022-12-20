<?php  // creating a connection to get data from the database
	$conn = mysqli_connect("localhost", "root", "" ,"contacts");
	$sql = "SELECT * FROM user_login";
	$results = $conn->query($sql);	
	$row =mysqli_fetch_assoc($results);


session_start();
if(isset($_POST["login"])){
	  $name2 = $_POST["name"];
	  $password2 = $_POST["password"];
	  $result = mysqli_query($conn, "SELECT * FROM user_login WHERE name = '$name2'");
	  $row = mysqli_fetch_assoc($result);
	  if(mysqli_num_rows($result) > 0){
	    if($password2 == $row['password']){
	      $_SESSION["login"] = true;
	      $_SESSION["name"] = $row["name"];
	      header("Location: ../addcontact.php");
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