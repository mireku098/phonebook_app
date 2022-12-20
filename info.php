<?php 

session_start();

if (!isset($_SESSION['name'])) {
    header("Location: ./login.php");
}



//creating a connection to  the database 
$conn = mysqli_connect("localhost", "root", "" ,"contacts");
$sql = "SELECT * FROM user_login WHERE name ";
$results = $conn->query($sql)->fetch_assoc();


?>
<!doctype html>
<html lang="en">
  <head>
    <title>User Info</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./adminlte.min.css">
  </head>
  <body>
    
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5">
              <div><a href="info.php" class="img logo rounded-circle mb-5" style="background-image: url(./img1.jpg);"></a>
               </div>          
               <ul class="list-unstyled components mb-5">
            <li>
             <a href="home.php" >Home</a>
                
              </li>
              <li>
                  <a href="display.php">Contacts</a>
              </li>
              <li>
              <a href="addcontact.php">Add new Contacts</a>
              </li>
              <li class="active">
              <a href="info.php">User info</a>
              </li>
              
               <li>
              <a href="logout.php">Log Out</a>
              </li>
              </ul>
            
          </ul> 
        </div>
      </nav> 
    

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
                
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="nav navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="display.php">Contacts</a>
                </li>
                <li class="nav-item ">
                   <a class="nav-link" href="addcontact.php">Add new Contacts</a>   
                </li>
                <li class="nav-item active">
                   <a class="nav-link" href="info.php">User Info</a>   
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="logout.php">Log Out</a>   
                </li>
              </ul>
            </div>
          </div>
        </nav>
       
       <div><h2> My Name</h2><?php echo  $_SESSION['name'];  ?></div>
       <div><h2> My Email</h2><?php echo  $_SESSION['email'];  ?></div>

       
    <script src="./jquery.min.js"></script>
    <script src="./popper.js"></script>
    <script src="./bootstrap.min.js"></script>
    <script src="./main.js"></script>
  </body>
</html>