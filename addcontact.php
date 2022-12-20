<?php 
error_reporting(E_ALL);
ini_set("display_errors", "1");
    session_start();
    if (!isset($_SESSION['name'])) {
        header("Location: ./login.php");
    }
?>

<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contacts";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if (!$conn) {
  die("connection failed").mysqli_connect_error();
} 

      //header("Refresh:0.1; url=edit.php?a=$id");

if (isset($_POST['savebtn'])){ 
  $title = $_POST['title'];         
  $name1 = $_POST['boxOfName1'];
  $name2 = $_POST['boxOfName2'];
  $number = $_POST['boxOfNumber'];
  $email = $_POST['boxOfEmail'];
  $relationship = $_POST['relationship'];
  $location =$_POST['location'];
  $company = $_POST['company'];
  $event = $_POST['event'];
  $date = $_POST['date'];
  $website = $_POST['website'];
  $filename = $_FILES["uploadfile"]["name"];
  $tempname = $_FILES["uploadfile"]["tmp_name"];
  $folder = "./image/" . $filename;
  $location = $_POST['location'];
  $user_id = $_SESSION["id"];
  
      $INSERT = "INSERT INTO contact_lists(title,first_name,surname,number,email,user_id,filename,location,company,relationship,event,date,website)values(?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
  
  $stmt = $conn->prepare($INSERT);
  $stmt->bind_param("sssssssssssss",$title, $name1, $name2, $number ,$email, $user_id, $filename,$location,$company,$relationship,$event,$date,$website);
  $stmt->execute();
$stmt->close();
        
 
if (move_uploaded_file($tempname, $folder)) { } 

         echo "<script>alert('Contact Added successfully') </script>";
}

?>
<?php
  $user_id= $_SESSION["id"];
  
$collums = "";
$values = "";

if (isset($_POST['savebtn'])) 
 {
       $select =  "SELECT MAX(id) FROM contact_lists where user_id = $user_id";
         $RESULT = $conn->query($select);
         $RESULT = $RESULT->fetch_assoc();
           // print_r( $collums );
         $RESULT = $RESULT['MAX(id)'];
         $collums = "contact_id";
          $values = "'$RESULT'";
      $resultSet =$conn->query( "SELECT * FROM user_field where user_id = $user_id");
          while  ($row = $resultSet->fetch_assoc()) 
          {
            $r = $row['input_label']; $p = $row['placeholder']; $t = $row['input_type'];  $options = $row['options'];
            if (strlen($collums)== 0 ) {
              $collums = $collums . $r ;
              $values = $values . "'". $_POST[$r]. "'";
              
            }else{
              $collums = $collums .','. $r;
              $values = $values . ','. "'".  $_POST[$r]. "'";
            }
            //echo "$values";
          }
         
      
         $nume =$conn->query("INSERT INTO others_user_$user_id($collums) values($values)");
         // print_r($nume);
         
  }

?>


  <?php
    if (isset($_POST['savebtn'])){ 
        $num = "SELECT * FROM titles where title = '$title'";
    if ($stmt = $conn->prepare($num)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;

     if ($var == 0){ 
     $in= "INSERT INTO titles(title) values ('$title')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }           
    $eve = "SELECT * FROM event where event = '$event'";
    if ($stmt = $conn->prepare($eve)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;

     if ($var == 0){ 
     $in= "INSERT INTO event(event) values ('$event')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }         
    $com = "SELECT * FROM company where company = '$company'";
    if ($stmt = $conn->prepare($com)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;

     if ($var == 0){ 
     $in= "INSERT INTO company(company) values ('$company')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }

    $rel = "SELECT * FROM relationship where relationship = '$relationship'";
    if ($stmt = $conn->prepare($rel)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;

     if ($var == 0){ 
     $in= "INSERT INTO relationship(relationship) values ('$relationship')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }
    $loc = "SELECT * FROM location where location = '$location'";
    if ($stmt = $conn->prepare($loc)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;
     if ($var == 0){ 
     $in= "INSERT INTO location(location) values ('$location')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }
     $stmt->close();
      $conn->close(); 
    }
    // header("Refresh:0.1; url=addcontact.php");
?> 
<?php 
  $conn = mysqli_connect($servername,$username,$password,$dbname);
  if (!$conn) {
    die("connection failed").mysqli_connect_error(); } 
  if (isset($_POST['sub'])){ 
    $input_label =$_POST['input_label'];
    $input_type = $_POST['input_type'];
    $placeholder = $_POST['placeholder'];
    $input_require = $_POST['input_require'];
    $options = $_POST['options'];
    $user_id = $_SESSION["id"];
    $input_label = str_replace("'", "_apostrophe_", $input_label);
    $input_label = preg_replace('/\s+/', '_space_', $input_label);
    $INSERT = "INSERT INTO user_field(user_id,input_label,input_type,placeholder,input_require,options)values(?,?,?,?,?,?)";
    $stmt = $conn->prepare($INSERT);
    $stmt->bind_param("ssssss", $user_id, $input_label,$input_type,$placeholder,$input_require,$options);
    $stmt->execute();
    $stmt->close();
    $column =("ALTER TABLE others_user_$user_id ADD `$input_label` VARCHAR(220) NOT NULL ");
    //die($column);
    $create_table = $conn->prepare($column);
    $create_table->execute();
    $create_table->close();
    echo "<script>alert('Field Created successfully') </script>";
  }
?> 
      
<!doctype html>
<html lang="en">
  <head>
    <title>Add Contact</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 ">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./adminlte.min.css">
  </head>
  <body>
  <script src="script.js"></script>

  <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
        <div class="p-4 pt-5">
         <div><a href="info.php" class="img logo rounded-circle mb-5" style="background-image: url(./img1.jpg);"></a>
               </div>
          
          <ul class="list-unstyled components mb-5">
            <li >
                <a href="home.php" >Home</a>
                
              </li>
              <li >
                  <a href="display.php">Contacts</a>
              </li>
              <li class="active">
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
                <li class="nav-item">
                    <a class="nav-link" href="display.php">Contacts</a>
                </li>
                <li class="nav-item active">
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

      

  
      <form action="" method="post"  enctype="multipart/form-data">
        <div class="login-logo">
        <div class="container-fluid " >
          <div class="card" style="width: 100%; height: 100%;">
          <h1 >Add Contact</h1>
        <label for="uploadfile">Insert Image</label>
        <input class="form-control" type="file"  name="uploadfile" id="uploadfile" value="" />
       <label for="title">Title </label>
        <div class="input-group mb-3">
         <select class="form-control" id="title" name="title" >  
         <?php
          $conn = mysqli_connect("localhost", "root", "" ,"contacts");
          $resultSet =$conn->query( "SELECT title FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['title'];  
          }
            ?>
             <?php
          $conn = mysqli_connect("localhost", "root", "" ,"contacts");
          $resultSet =$conn->query( "SELECT title FROM titles");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['title'];
            if($t == $title){
             echo "<option value =" ."\"" .$t. "\""." selected>$t</option> " ;
              }else {
             echo "<option value =" ."\"" .$t. "\""." >$t</option> " ;}
          }
            ?> 
            
          </select>
          <div class="input-group-append">
            
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode"><i class="fa fa-plus"></i></button>
        </div>
        <label for="boxOfName1">First Name</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="boxOfName1" id="boxOfName1" placeholder="First name"  required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <label for="boxOfName2">Surname </label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="boxOfName2" id="boxOfName2" placeholder="Surname"  required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> 
       <label for="boxOfNumber"> Phone Number </label>
        <div class="input-group mb-3">
          <input type="number" class="form-control" name="boxOfNumber" id="boxOfNumber" placeholder="Phone Number"  maxlength="10" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <label for="relationships">Relationship</label>
        <div class="input-group mb-3">
          <select class="form-control" id="relationships" name="relationship"> 
           <?php
          
          $resultSet =$conn->query( "SELECT relationship FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['relationship'];  
          }
            ?>
             <?php
          
          $resultSet =$conn->query( "SELECT relationship FROM relationship");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['relationship'];
            if($t == $title){
             echo "<option value =" ."\"" .$t. "\""."  selected>$t</option> " ;
              }else {
             echo "<option value =" ."\"" .$t. "\""." >$t</option> " ;}
          }
            ?> 
          </select>
          <div class="input-group-append">
            
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode2"><i class="fa fa-plus"></i></button>
        </div>
         <label for="boxOfEmail">Email </label>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name = "boxOfEmail" id ="boxOfEmail" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label for="date"> Type Of Event</label>
        <div class="input-group mb-3">
          <input type="date" class="form-control" name = "date" id ="date">
          <select class="form-control"  id="events" name="event"> 
            <?php
          $resultSet =$conn->query( "SELECT event FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['event'];  
          }
            ?>
             <?php      
          $resultSet =$conn->query( "SELECT event FROM event");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['event'];
            if($t == $title){
             echo "<option value =" ."\"" .$t. "\""."  selected>$t</option> " ;
              }else {
             echo "<option value =" ."\"" .$t. "\"".">$t</option> " ;}
          }
            ?> 
          </select><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode3"><i class="fa fa-plus"></i></button>
          
          <div class="input-group-append">
            
          </div>
        </div>
         <label for="locations">Location</label>
        <div class="input-group mb-3">
          <select class="form-control" id="locations" name="location" required>
            <?php
         $location = NULL;
          
          $resultSet =$conn->query( "SELECT location FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $location = $rows['location'];
            
          }
            ?> 
            
             <?php
          
          $resultSet =$conn->query( "SELECT location FROM location");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['location'];
            if($title == $location){
             echo "<option value =" ."\"" .$title. "\""."  selected >$title</option> " ;

              }else {

             echo "<option value =" ."\"" .$title. "\"".">$title</option> " ;}

                      }            
            ?>

          </select>
          <div class="input-group-append">
            
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode4"><i class="fa fa-plus"></i></button>
        </div>
         <label for="companies">Company</label>
        <div class="input-group mb-3">
          <select class="form-control" id="companies" name="company" required>
          <?php
          $resultSet =$conn->query( "SELECT company FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['company'];  
          }
            ?>
             <?php
          $resultSet =$conn->query( "SELECT company FROM company");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['company'];
            if($t == $title){
             echo "<option value =" ."\"" .$t. "\""." selected>$t</option> " ;
              }else {
             echo "<option value =" ."\"" .$t. "\""." >$t</option> " ;}
          }
            ?> 
          </select>
          <div class="input-group-append">
            
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode5"><i class="fa fa-plus"></i></button>
        </div>
         <label for="website">Website</label>
        <div class="input-group mb-3">
          <input class="form-control" type="text" name="website" id="website" placeholder="Enter the URL or name of website" required>
          <div class="input-group-append">
          </div>
        </div>

          <?php 
             error_reporting(0);
              $input_label = $_POST['input_label'];
              $input_type = $_POST['input_type'];
              $placeholder = $_POST['placeholder'];
              $description = $_POST['description'];
              $input_require = $_POST['input_require'];
              $user_id = $_SESSION["id"];    

                $resultSet =$conn->query( "SELECT * FROM user_field where user_id = $user_id");
                while  ($row = $resultSet->fetch_assoc()) 
                {    // print_r($row);
                   $r = $row['input_label']; $p = $row['placeholder'];  $t = $row['input_type'];  $options = $row['options'];
                   $options_explode = explode("," ,$row['options']);    
                   $replace_r = str_replace("_apostrophe_", "'", $r);
                   $replace_r = str_replace("_space_"," ",$replace_r);
                   

                  if ($t == 'text' )
                    {
                      echo "<label for=$r >$replace_r</label>
                      <div class='input-group mb-3' >";
                        if ($input_require == "yes")
                          {
                            echo "<input class='form-control' type='$t' name='$r' id='$r' placeholder=" ."\"" .$p. "\"". " / required> ";
                          }
                         else {
                          echo "<input class='form-control' type='$t' name='$r' id='$r' placeholder=" ."\"" .$p. "\"".  " /> ";
                              } 
                      
                      echo" <div class='input-group-append'>

                      </div>
                      </div>";
                     }
                  if ($t == 'select')
                  {
                  echo "<label for=$r >$replace_r</label>
                  <div class='input-group mb-3' >";
                  $a = "<option value=''>Select $replace_r </option>";
                  foreach ($options_explode as $key => $value) {
                        $a = $a . "<option value='$value'>$value</option>";       
                  }
                    
                  echo "<select class='form-control' name='$r'>
                          $a
                      </select> ";                
              
                   echo" <div class='input-group-append'>
                    </div>
                  </div>";
                }
                
            } 
          ?>
        <div class="row">
          <div class="col-4">
            <button type="submit" name="savebtn" class="btn btn-primary btn-block mb-3 mt-3 ml-3">Save</button>
          </div>
          <div class="col-4">
            <nobr><button type="button" class="btn btn-primary  mb-3 mt-3 ml-3" data-toggle="modal" data-target="#mode6">Add Custom Fields</button></nobr>
          </div> 
        </div>

        </div>
        </div>
        </div> 
      </form>
      
   </div>
      </div>      
              <script src="./jquery.min.js"></script>
              <script src="./popper.js"></script>
              <script src="./bootstrap.min.js"></script>
              <script src="./main.js"></script>
             
           <!-- pop up form to add an option to Title -->
              <div class="modal fade" id="mode" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                
                <div class="modal-body">
                  <form  class="form-container">
                  <label for="option"><b>Add New Title</b></label>
                <input type="text"  name="option" id="val">
              </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button"  onclick="insertValue();" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div> 
          <!-- pop up form to add custom field -->
          <div class="modal fade" id="mode6" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form-container"> 
                    <!-- content -->
                     <input class="form-control" type="text" placeholder="Enter Label Name" id="input_label" name="input_label" required>
                    <select class="form-control mt-3 mb-3" id="input_type" name="input_type" onchange="app(this);">
                      <option value=" ">Choose Field Type</option>
                      <option value="text">Text Area</option>
                      <option value="select">Select Field</option>
                    </select>
                    <div id="text" style="display: none;" >
                       <p>Note that every option you want to add should be seperated with a comma (,).</p>
                      <input type="text" name="options" class="form-control mt-3 mb-3">
                      </div>
                      <input class="form-control mt-3 mb-3" type="text" placeholder="Text to Input in Placeholder" id="placeholder" name="placeholder" required>
                      <select class="form-control" id="input_require" name="input_require">
                      <option>Is it compulsory to filled?</option>
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                  
                    <!-- content --><br>
                    <button type="submit"  class="btn btn-primary" name="sub" >Submit</button>
              </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>   
               </div>
             </div>
            </div>
          </div>


          <!-- pop up form to add an option to Relatinship -->
              <div class="modal fade" id="mode2" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                
                <div class="modal-body">
                  <form  class="form-container">
                  <label for="option"><b>Add Relationship</b></label>
                <input type="text"  name="option" id="relationship">
              </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button"  onclick="insertValue2();" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div> 

          <!-- pop up form to add an option to Event -->
              <div class="modal fade" id="mode3" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                
                <div class="modal-body">
                  <form  class="form-container">
                  <label for="option"><b>Add New Event</b></label>
                <input type="text"  name="option" id="event">
              </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button"  onclick="insertValue3();" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div> 

          <!-- pop up form to add an option to Location -->
              <div class="modal fade" id="mode4" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                
                <div class="modal-body">
                  <form  class="form-container">
                  <label for="option"><b>Add A Location</b></label>
                <input type="text"  name="option" id="location">
              </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button"  onclick="insertValue4();" class="btn btn-primary" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div> 

            <!-- pop up form to add an option to Company -->
                <div class="modal fade" id="mode5" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  
                  <div class="modal-body">
                    <form  class="form-container">
                    <label for="option"><b>Add Company Name</b></label>
                  <input type="text"  name="option" id="company">
                </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button"  onclick="insertValue5();" class="btn btn-primary" data-dismiss="modal">Save</button>
                  </div>
                </div>
              </div>
            </div> 


  </body>
</html>