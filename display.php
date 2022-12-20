<?php 
ini_set("display_errors", "1");
 error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: ./login.php");
}
$conn = mysqli_connect("localhost", "root", "" ,"contacts");
$sql = "SELECT * FROM user_login";
$results = $conn->query($sql)->fetch_assoc();

?>
<?php
    $user_id = $_SESSION['id'];
    if(isset($_POST['search']))
    {
        $valueToSearch =   $_POST['valueToSearch'] ;

    }else{
        $valueToSearch = "";
    }
    
            $mysqli_query = $conn->query("SELECT * FROM user_field where user_id = $user_id");
            $s = "";
            $rowcount=mysqli_num_rows($mysqli_query);
            
            
                while($user_field = $mysqli_query->fetch_assoc()){
                    if(strlen($s) == 0){
                        $s = $s . "others_user_$user_id." . $user_field["input_label"]; 
                    }else{
                        $s = $s . ','.   "others_user_$user_id.".$user_field["input_label"]  ; 
                    }
                }
           
            // print_r($s);
        // print_r($rowcount);
        if (strlen($s) !== 0 ){
            $query = "SELECT * FROM contact_lists INNER JOIN others_user_$user_id ON others_user_$user_id.contact_id WHERE contact_lists.user_id = $user_id AND others_user_$user_id.contact_id = contact_lists.id  AND CONCAT(contact_lists.first_name, contact_lists.surname, contact_lists.number,contact_lists.email,contact_lists.location,contact_lists.company,contact_lists.relationship,contact_lists.event,contact_lists.date,contact_lists.website ) LIKE '%$valueToSearch%' OR contact_lists.user_id = $user_id AND others_user_$user_id.contact_id= contact_lists.id AND CONCAT($s) LIKE '%$valueToSearch%'"; 
             // print_r($query);
            $search_result = filterTable($query);
        } else{
                $query = "SELECT * FROM contact_lists  WHERE contact_lists.user_id = $user_id ";
                $search_result = filterTable($query);
            }


// function to connect and execute the query
function filterTable($query)
{

    $connect = mysqli_connect("localhost", "root", "", "contacts");
    $filter_Result = mysqli_query($connect, $query);
    // print_r($query);

    // die();
    return $filter_Result;
}

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Contacts</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet"> -->
    
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="./style.css">

      <!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="./adminlte.min.css">

  </head>
  <body>
    
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5">
            <div><a href="info.php" class="img logo rounded-circle mb-5" style="background-image: url(images/img1.jpg);"></a>
               </div>
          <ul class="list-unstyled components mb-5">
            <li >
                <a href="home.php">Home</a>
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
      <div id="content" >
        <div class="container-fluid ">
            <div class="card" style="width: 100%; height: 100%;">
                <div class="card-header" style="background-color: tan;">
                    <h1 >List of Contacts</h1> 
                    <form action="" method="post">
                        <div class="input-group"><input class="form-control" type="text" name="valueToSearch"  placeholder="Search">
                            <button type="submit" class="btn btn-primary" name="search"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                  <!-- /.card-header -->
                  <div class="table-responsive" >
                    <table class="table table-bordered table-sm">
                        
                          <th>Image</th>
                          <th>Name</th>
                          <th>Number</th>
                          <th>Email</th>
                          <th>Location</th>
                          <th>Company</th>
                          <th>Relaionship</th>
                          <th>Event</th>
                          <th>Date</th>
                          <th>Website</th>
                        <?php
                            $mysqli_query = $conn->query("SELECT * FROM user_field where user_id = $user_id ");
                            while ($assoc = $mysqli_query->fetch_assoc()) {
                               $label = $assoc['input_label'];
                                $replace_r = str_replace("_apostrophe_", "'", $label);
                                $replace_r = str_replace("_space_"," ",$replace_r);
                                echo "<th><nobr>$replace_r<nobr></th>";
                                
                                } 
                        ?>
            <?php                                                                                  
                while($row = mysqli_fetch_array($search_result)){
                  echo "<tr><td><a href ='detail.php?a=$row[id]'><img class=' rounded-circle'  style='margin: 5px; width: 90px; height: 90px;'src='image/".$row['filename']."'></a>
                    </td><td><nobr><a href ='detail.php?a=$row[id]' >".$row["first_name"]." ".$row["surname"]."</nobr></td><td>".$row["number"]. "</td><td>".$row["email"]. "</td><td>".$row["location"]. "</td><td>".$row["company"]. "</td><td>".$row["relationship"]. "</td><td>".$row["event"]. "</td><td><nobr>".$row["date"]. "</nobr></td><td>".$row["website"]. "</td>";
                                $mysqli_query = $conn->query("SELECT * FROM user_field where user_id = $user_id ");    
                                while ($assoc = $mysqli_query->fetch_assoc()) {
                                    $label = $assoc['input_label'];
                                    // print_r($label);
                               echo " <td><nobr>".$row[$label]. "</nobr></td>";
                            }
              }      
                                            
            ?>
                    
                    </table>
                </div>              
            </div>

        </div>
        <div>
        </div>
    
     </div>       

    
    <script src="./jquery.min.js"></script>
    <!-- <script src="js/popper.js"></script> -->
    <script src="./bootstrap.min.js"></script>
    <script src="./main.js"></script>
  </body>
</html>