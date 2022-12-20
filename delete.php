<?php
ini_set("display_errors", "1");
 error_reporting(E_ALL);
session_start();

 //getting the value of "a" & assigning it to a variable
$nm = $_GET['a'];
//creating a connection to  the database 
$conn = mysqli_connect("localhost","root","");
mysqli_select_db( $conn,"contacts");
//a query to delete the content of the row in the table of a database
$user_id = $_SESSION['id'];
$query =  "DELETE contact_lists , others_user_$user_id  FROM contact_lists  INNER JOIN others_user_$user_id  
WHERE contact_lists.id= others_user_$user_id.contact_id and contact_lists.id = '$nm'";
mysqli_query($conn,$query);
print_r($query);
// if ($query){
//      echo "<script>alert('Contact successfully deleted ?') </script>";
// }
//redirecting to the the display link automatically
header("location:display.php");
?>