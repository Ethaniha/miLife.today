<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];


?>

<html>
   
  <head>
    <title>miLIFE | My Groups</title>
      
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <?php include("head.php"); ?>
<div class="main-wrapper">
  <div class="container">

    <h1 class="pageHeader">My Groups</h1>
                <a class="btn btn-primary" data-toggle="modal" data-target="#addGroup" href="#"><span class="fas fa-plus"></span> Create a new group</a> 
        </div>

  </div>
  <div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalCenterTitle">Create a new Group</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post" enctype="multipart/form-data">
      <h6>ADD A GROUP NAME</h6>
      <input type = "text" name = "name" class="form-control">
      <br>
      <h6>DESCRIPTION</h6>
      <textarea  class="form-control" name="postbody" rows="5" cols="80"></textarea>
      <br>
      <h6>GROUP IMAGE</h6>
      <input type = "file" name = "image" class="btn btn-light form-control">
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="createGroup" value="Create" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <?php include("footer.php"); ?>
  </body>
</html>
