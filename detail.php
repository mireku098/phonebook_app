<?php 
ini_set("display_errors", "1");
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: ./login.php");
}
$user_id = $_SESSION['id'];
//getting the value of "a" & assigning it to a variable
$nm = $_GET['a'];
//creating a connection to  the database 
$conn = mysqli_connect("localhost", "root", "" ,"contacts");
$sql = "SELECT * FROM contact_lists where id = '$nm'";
$results = $conn->query($sql)->fetch_assoc();
?>
<?php 
$id = $_SESSION["id"];
$sq = "SELECT * FROM others_user_$id where contact_id = '$nm'";
$result = $conn->query($sq)->fetch_assoc();
$e = gettype($result);
// print_r($e);
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Contact Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./adminlte.min.css">
  </head>
  <body>
    
    <div class="wrapper d-flex align-items-stretch" >
      <nav id="sidebar">
        <div class="p-4 pt-5">
            <div>
                <a href="info.php" class="img logo rounded-circle mb-5" style="background-image: url(./img1.jpg);"></a>
            </div>
            <ul class="list-unstyled components mb-5">
            <li>
              <a href="home.php" >Home</a>
              
            </li>
            <li class="active">
                <a href="display.php">Contacts</a>
            </li>
            <li>
              <a href="addcontact.php">Add New Contacts</a>
            </li>
            <li>
              <a href="info.php">User info</a>
            </li>
              
               <li>
              <a href="logout.php">Log Out</a>
              </li>
          </ul>

         
        </div>
      </nav> 


        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">

        <nav class="navbar navbar-expand-lg navbar-light bg-light ">
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
                <li class="nav-item active">
                    <a class="nav-link" href="display.php">Contacts</a>
                </li>
                <li class="nav-item ">
                   <a class="nav-link" href="addcontact.php">Add New Contacts</a>   
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="info.php">User Info</a>   
                </li>                
                <li class="nav-item">
                   <a class="nav-link" href="logout.php">Log Out</a>   
                </li>
              </ul>
            </div>
          </div>
        </nav>
<div class="container-fluid "> 
    <div class="card" style="width: 100%; height: 100%;"><center><h3>Contact Details</h3></center>
          <div class="col"><center><?php echo "<img class='img-fluid'  src='image/".$results['filename']."'>"; ?></center>
          </div>
        <div class="card-body">
              <div class="row" >   
                <div class="col">
                    <div class="col"><h3>Title</h3><?php echo $results["title"]; ?></div> 
                            <br>
                    <div class="col"><h3>First Name</h3><?php echo $results["first_name"]; ?></div>
                            <br>        
                    <div class="col"><h3>Surname</h3><?php echo $results["surname"]; ?></div>
                            <br>       
                    <div class="col"><h3>Number</h3><?php echo $results['number']; ?></div>
                            <br>
                    <div class="col"><h3>Email</h3><?php echo $results["email"]; ?></div>
                            <br>           
                     <div class="col"><h3>Location</h3><?php echo  $results["location"];  ?></div>
                      <br>
                    <div class="col"><h3>Relationship</h3><?php echo $results["relationship"]; ?></div>
                            <br>
                    <div class="col"><h3>Event</h3><?php echo $results["event"]; ?></div>
                            </div>

                <div class="col">      
                    <div class="col"><h3>Date</h3><?php echo $results["date"]; ?></div>
                            <br>
                    <div class="col"><h3>Company</h3><?php echo $results["company"]; ?></div>
                            <br>
                    <div class="col"><h3>Website</h3><?php echo $results["website"]; ?></div>


                <?php 
                if ($e == "array")
                { 
                     $resultSet =$conn->query( "SELECT * FROM user_field where user_id = $user_id");
                          while  ($row = $resultSet->fetch_assoc()) 
                          {
                            $r = $row['input_label']; $p = $row['placeholder']; $t = $row['input_type'];  $options = $row['options']; 
                           $replace_r = str_replace("_apostrophe_", "'", $r);
                    $replace_r = str_replace("_space_"," ",$replace_r); 
                    echo "<br> <div class='col'><h3>$replace_r</h3>".$result[$r] ."</div>";
                     }
                } 

                 ?>
                </div>
                    </div><br>
                 <div class="row">
                 <div class="col-4" > <a href="display.php"><button class="btn btn-primary">Back</button></a></div>
                 <div class="col-4" > <?php  echo "<a href='edit.php?a=$nm'><button class='btn btn-primary'>Edit</button></a> "?></div>
                 <div class="col-4" > <?php  echo "<button class = 'btn btn-danger' ><a onClick=\"javascript: return confirm('Are you sure you want to delete this contact?');\" href='delete.php?a=$nm' style='color:white; text-decoration: none;' >Delete</a></button>"?></div>
                </div>
        </div>
    </div>
</div>    
   
    <script src="./jquery.min.js"></script>
    <script src="./popper.js"></script>
    <script src="./bootstrap.min.js"></script>
    <script src="./main.js"></script>
</div>   
</div>
  </body>
</html>