<?php 
session_start();

include("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID, Email, Forename, Surname, image  FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row=mysqli_fetch_array($result)) {

    $userid = $row[0];
    $email = $row[1];
    $forename = $row[2];
    $surname = $row[3];
    $avatar = $row[4];
    
    //echo $row[1]. " ".$row[2]. " ". $row[3]. "<img src='images/users/".$row[4]."' width=100 height=100 />";
  }
}

   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be less than 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"../Assets/imgs/users/".$file_name);
         
         $sql = "UPDATE users  SET image = '$file_name' WHERE email = '$myusername' ";
         mysqli_query($db, $sql);

      }else{
         print_r($errors);
      }
   }
?>

<html>
   
  <head>
    <title>miLIFE | Settings</title>
      
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <?php include("head.php"); ?>

<div class="container">
  <h3 class="pageHeader">User Settings</h3>
  <table class="table-sm">
    <tr>
      <td><?php echo "<img src='../Assets/imgs/users/".$avatar."' width=100 height=100 />"; ?></td><td></td>
    </tr>
    <tr>
      <td>User ID:</td><td><?php echo $userid; ?></td>
    </tr>
    <tr>
      <td>Forename:</td><td><?php echo $forename; ?></td>
    </tr>
    <tr>
      <td>Surname:</td><td><?php echo $surname; ?></td>
    </tr>
    <tr>
      <td>Email:</td><td><?php echo $email; ?></td>
    </tr>
  </table>

  <form action = "" method = "POST" enctype = "multipart/form-data">
     <input type = "file" name = "image" />
     <input type = "submit"/>
  </form>

  <a href="logout.php" class="btn btn-danger">Logout</a>


</div>
  


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  </body>
</html>




