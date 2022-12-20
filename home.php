<?php 
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: ./login.php");
}
//creating a connection to  the database 
$conn = mysqli_connect("localhost", "root", "" ,"contacts");
$sql = "SELECT * FROM user_login";
$results = $conn->query($sql)->fetch_assoc();
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    
   <!--  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  
   
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<div><a href="info.php" class="img logo rounded-circle mb-5" style="background-image: url(./img1.jpg);"></a>
               </div>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
	            <a href="home.php" >Home</a>
	            
	          </li>
	          <li>
	              <a href="display.php">Contacts</a>
	          </li>
	          <li>
              <a href="addcontact.php">Add New Contacts</a>
	          </li>
	          <li>
              <a href="info.php">User info</a>
	          </li>
              
               <li>
              <a href="mike/logout.php">Log Out</a>
              </li>
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
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="display.php">Contacts</a>
                </li>
                <li class="nav-item ">
                   <a class="nav-link" href="addcontact.php">Add New Contacts</a>   
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="info.php">User Info</a>   
                </li>                
                <li class="nav-item">
                   <a class="nav-link" href="mike/logout.php">Log Out</a>   
                </li>
              </ul>
            </div>
          </div>
        </nav>

       <center><h2> Welcome <?php echo  $_SESSION['name'];  ?>
       </h2></center>
       <br>


            <div><img name="slide" width="100%" height="350px" /></div>

    <script src="/jquery.min.js"></script>
    <!-- <script src="js/popper.js"></script> -->
    <script src="/bootstrap.min.js"></script>
    <script src="/main.js"></script>
    <script type="text/javascript">
        var i = 0;       
var images = [];    
var time = 4000;    
     
// Image List
images[0] = "./img6.jpg";
images[1] = "./img5.jpg";
images[2] = "./img2.jpg";
images[3] = "./img1.jpg";
images[4] = "./img3.jpg";
images[5] = "./img4.jpg";
// Change Image
function changeImg(){
    document.slide.src = images[i];

    
    if(i < images.length - 1){
      // Add 1 to Index
      i++; 
    } else { 
        
        i = 0;
    }
    setTimeout("changeImg()", time);
}
window.onload=changeImg;
    </script>
  </body>
</html>