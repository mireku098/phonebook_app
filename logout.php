<?php
$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
?>
<?php 

session_start();
session_destroy();

header("Location: login.php");

?>