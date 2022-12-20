<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "contacts";
$conn = mysqli_connect("localhost", "root", "" ,"contacts");
    $sql = "SELECT * FROM user_login";
    $results = $conn->query($sql);  
    $row =mysqli_fetch_assoc($results);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>