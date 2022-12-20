<?php 
// ini_set("display_errors", "1");
//  error_reporting(E_ALL);
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
// print_r($result);
$e = gettype($result);
// print_r($e);
?>
<?php 
if (!isset($_SESSION['name'])) {
    header("Location: ./login.php");
}
$user_id = $_SESSION['id'];
?>
 <?php 
 //    ini_set("display_errors", "1");
 // error_reporting(E_ALL);
    $input_label = $_POST['input_label'];
    $input_type = $_POST['input_type'];
    $placeholder = $_POST['placeholder'];
    $description = $_POST['description'];
    $input_require = $_POST['input_require'];     
    $title = $_POST['title'];
    $name1 = $_POST['boxOfName1'];
    $name2 = $_POST['boxOfName2'];
    $number = $_POST['boxOfNumber'];
    $email = $_POST['boxOfEmail'];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;
    $location = $_POST['location'];
    $id = $_POST['id'];
    $relationship = $_POST['relationship'];
    $company = $_POST['company'];
    $event = $_POST['event'];
    $date = $_POST['date'];
    $website = $_POST['website'];
  
    if (isset($_POST['update'])){ 
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
    $loc = "SELECT * FROM location where location = '$location'";
    if ($stmt = $conn->prepare($loc)) {
        $stmt->execute();
        $stmt->store_result();
        
    }
    $var = $stmt->num_rows;
    //print($var);
     if ($var == 0){ 
     $in= "INSERT INTO location(location) values ('$location')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
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
    // print($var);
     if ($var == 0){ 
     $in= "INSERT INTO relationship(relationship) values ('$relationship')  ";
    $stmt = $conn->prepare($in);
        $stmt->execute();
    }         

    $update = mysqli_query($conn, "UPDATE contact_lists SET title = COALESCE(NULLIF('$title',''),title) ,first_name = '$name1',surname ='$name2' ,filename =  COALESCE(NULLIF( '$filename' ,''),filename) ,number = '$number', location = COALESCE(NULLIF( '$location' ,''),location), email = '$email',company = COALESCE(NULLIF( '$company' ,''),company),relationship = 
        COALESCE(NULLIF( '$relationship' ,''),relationship),event = COALESCE(NULLIF( '$event' ,''),event),date = '$date',website = '$website' WHERE id = '$id'");

    if ($update){
      echo "<script>alert('Contact Updated  successfully') </script>";}

    
} 
?>
<?php 
    if (isset($_POST['update'])) {        
          $pro = $conn->query("SELECT * FROM others_user_$user_id where contact_id = $id");
          $rows = $pro->fetch_assoc();      
          $pros = $rows['contact_id'];
          $collums = ""; $values = ""; $set= "";
          if ($pros == $id){   
            $resultSet =$conn->query( "SELECT * FROM user_field where user_id = $user_id");
                while  ($row = $resultSet->fetch_assoc()) 
                {
                  $r = $row['input_label']; $p = $row['placeholder']; $t = $row['input_type'];  $options = $row['options']; 
                  if (strlen($set)== 0 ) {
                    $set = $set . $r."='". $_POST[$r]."'";   
                  }else{
                    $set = $set .",". $r. "='". $_POST[$r] . "'";
                  }
          }
          $bruh = $resultSet->num_rows;
          if ($bruh !== 0){
          $update2 = $conn->query("UPDATE others_user_$user_id SET $set  WHERE contact_id = $id");
            //print_r($resultSet);
        } 


          } else {
              
              $resultSet =$conn->query( "SELECT * FROM user_field where user_id = $user_id");
              while  ($row = $resultSet->fetch_assoc()) 
              {
                $r = $row['input_label']; $p = $row['placeholder']; $t = $row['input_type'];  $options = $row['options'];
                // print_r($values);
                if (strlen($collums)== 0 ) {
                  $collums = $collums . $r ;
                  $values =  $values . "'". $_POST[$r]. "'";
                  
                }else{
                  $collums =','. $collums .','. $r;
                  $values =  ','.$values . ','. "'".  $_POST[$r]. "'";
                }
              }
            $nume =$conn->query("INSERT INTO others_user_$user_id(contact_id$collums) values($id$values)");
            // print_r($nume);
        }
      if (move_uploaded_file($tempname, $folder)) {    } 
      header("Refresh:0.01; url=edit.php?a=$id");
     
  }
        
?>



<!doctype html>
<html lang="en">
  <head>
    <title>Edit Contact</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=deMisse-width, initial-scale=1">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./icheck-bootstrap.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
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
              <li  class="active">
                  <a href="display.php">Contacts</a>
              </li>
              <li>
              <a href="addcontact.php">Add New Contacts</a>
              </li>
              <li>
              <a href="info.php">User info</a>
              </li>
             
               <li>
              <a href="./logout.php">Log Out</a>
              </li>
             
          </ul>

        </div>
      </nav>


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
                <li class="nav-item" >
                   <a class="nav-link" href="addcontact.php">Add New Contacts</a>   
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="info.php">User Info</a>   
                </li>
                

                <li class="nav-item active">
                    <a class="nav-link" href="display.php">Contacts</a>
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
  <div class="login-logo">
  
  <!-- /.login-logo -->
 
    <div class="card" style="width: 100%; height: 100%;">
    <div class="card-body login-card-body">
      <h2 >Edit Contact</h2>
      <form action="" method="post" enctype="multipart/form-data">
        <div class="col-12">
        <?php
        echo "<img class='img-fluid' style='margin: 5px; width: 150px; height: 150px;' src='image/".$results['filename']."'>";
         ?>
        </div>
        <label for="image">Insert Image</label>
        <div class="input-group mb-3">
          <input class="form-control" type="file" id="image" name="uploadfile"  />
          <div class="input-group-append">
            <div class="input-group-text"> 
            </div>
          </div>
        </div> 
        <label for="title">Title </label>
          <div class="input-group mb-3">
         <select class="form-control" id="select" name="title" >
           
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
            <div class="input-group-text"> 
            </div>
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode"><i class="fa fa-plus"></i></button>
        </div>

        <label for="boxOfName1">First Name</label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="boxOfName1" id="boxOfName1" value="<?php echo $results["first_name"]; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <label for="boxOfName2">Surname </label>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="boxOfName2" id="boxOfName2" value="<?php echo $results["surname"]; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <label for="boxOfNumber"> Phone Number </label>
        <div class="input-group mb-3">
          <input type="number" class="form-control" name="boxOfNumber" id="boxOfNumber" value="<?php echo $results['number']; ?>" required minlength="10" maxlength="10" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <label for="relationships"> Relationship</label>
        <div class="input-group mb-3">
          <select class="form-control" id="relationships" name="relationship"> 
           <?php
          $conn = mysqli_connect("localhost", "root", "" ,"contacts");
          $resultSet =$conn->query( "SELECT relationship FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $title = $rows['relationship'];  
          }
            ?>
             <?php
          $conn = mysqli_connect("localhost", "root", "" ,"contacts");
          $resultSet =$conn->query( "SELECT relationship FROM relationship");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['relationship'];
            if($t == $title){
             echo "<option value =" ."\"" .$t. "\""." selected>$t</option> " ;
              }else {
             echo "<option value =" ."\"" .$t. "\"".">$t</option> " ;}
          }
            ?> 
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode2"><i class="fa fa-plus"></i></button>
        </div>
        <label for="boxOfEmail">Email </label>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name = "boxOfEmail" id ="boxOfEmail" value="<?php echo $results["email"]; ?>" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label for="date"> Type Of Event</label>
        <div class="input-group mb-3">
          <input type="date" class="form-control" name = "date" id ="date" value="<?php echo $results["date"] ?>">
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
             echo "<option value =" ."\"" .$t. "\""."  selected >$t</option> " ;

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
          <select class="form-control" id="locations" name="location">
            <?php
          $resultSet =$conn->query( "SELECT location FROM contact_lists where id = '$nm'");
          while ($rows = $resultSet->fetch_assoc()){
            $location = $rows['location'];
            }
            ?> 
            
             <?php
          $resultSet =$conn->query( "SELECT location FROM location");
          while ($rows = $resultSet->fetch_assoc()){
            $t = $rows['location'];
            if($t == $location){
             echo "<option value =" ."\"" .$t. "\""."  selected >$t</option> " ;

              }else {

             echo "<option value =" ."\"" .$t. "\""."  >$t</option> " ;}
          }       
            ?> 
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode4"><i class="fa fa-plus"></i></button>
        </div>
        <label for="companies">Company</label>
        <div class="input-group mb-3">
          <select class="form-control" id="companies" name="company">
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
             echo "<option value =$t  selected>$t</option> " ;
              }else {
             echo "<option value =$t >$t</option> " ;}
          }
            ?> 
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
          </div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mode5"><i class="fa fa-plus"></i></button>
        </div> 
        <label for="website">Website</label>
        <div class="input-group mb-3">
          <input class="form-control" type="text" id="website" name="website" value="<?php echo $results ["website"] ?>">
          <div class="input-group-append">
            <div class="input-group-text">
            </div>
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
      { 
         $r = $row['input_label']; $p = $row['placeholder'];  $t = $row['input_type'];  $options = $row['options'];
         $options_explode =explode("," ,$row['options']);    
         $replace_r = str_replace("_apostrophe_", "'", $r);
         $replace_r = str_replace("_space_"," ",$replace_r);
         // print_r($result[$r]);

        if ($t == 'text' )
          {
            echo "<label for=$r >$replace_r</label>
            <div class='input-group mb-3' >";
              if ($input_require == "yes")
                {
                  echo "<input class='form-control' type='$t' name='$r' id='$r' value='$result[$r]' placeholder=" ."\""    .$p.  "\"".   " / required> ";
                }
               else {
                echo "<input class='form-control' type='$t' name='$r' id='$r' value='$result[$r]' placeholder=" ."\""    .$p.  "\"".   " /> ";
                    } 
            
            echo" <div class='input-group-append'>
            <div class='input-group-text'>
            </div>
            </div>
            </div>";
           }

        if ($t == 'select')
        {
        echo "<label for=$r >$replace_r</label>
        <div class='input-group mb-3' >";

        $a = "<option value=''>Select $replace_r </option>";
        foreach ($options_explode as $key => $value) {          
          if ($result[$r] == $value){
            $a = $a."<option value='$value' selected>$value</option>";
          }   
          else{
            $a =$a . "<option value='$value' >$value</option>";
          }
          
        }
          
        echo "<select class='form-control' name='$r'>
                $a
            </select> ";                
    
         echo" <div class='input-group-append'>
         <div class='input-group-text'>
            </div>
          </div>
        </div>";
      }
      
  } 
?>

        <input type="hidden" name="id" value="<?php echo $results['id']?>">
        <div class="row">
          <div class="col-4">
            <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
          </div>
          <div class="col-4">
            <?php  echo "<a href='detail.php?a=$nm'><button type='button' class='btn btn-primary btn-block'>Cancel</button></a> "?>
          </div>
        </div>
      </form>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>      
</div>
      
        
<!-- <script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script> -->
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