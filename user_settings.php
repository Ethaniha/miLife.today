<?php 
session_start();

include("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID, Email, Forename, Surname, image, username  FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row=mysqli_fetch_array($result)) {

    $userid = $row[0];
    $email = $row[1];
    $forename = $row[2];
    $surname = $row[3];
    $avatar = $row[4];
    $username = $row[5];
    
    //echo $row[1]. " ".$row[2]. " ". $row[3]. "<img src='images/users/".$row[4]."' width=100 height=100 />";
  }
}
$sql = "SELECT id FROM post_likes WHERE user_id = '$userid' ";
$result = mysqli_query($db, $sql);
$likes = mysqli_num_rows($result);

$sql = "SELECT post FROM post WHERE user_id = '$userid' ";
$result = mysqli_query($db, $sql);
$posts = mysqli_num_rows($result);

$sql = "SELECT id FROM followers WHERE user_id = '$userid' ";
$result = mysqli_query($db, $sql);
$followers = mysqli_num_rows($result);

   if(isset($_FILES['image'])){

      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_temp = explode('.',$_FILES['image']['name']);
      $file_ext=strtolower(end($file_temp));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be less than 2 MB';
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp,"Assets/imgs/users/".$file_name);
         
         $sql = "UPDATE users  SET image = '$file_name' WHERE email = '$myusername' ";
         mysqli_query($db, $sql) or die(mysqli_error($db));

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
  <div class="main-wrapper">
<div class="container">	
<h1 class="pageHeader">My Settings</h1>
   <div class="row">
   <div class="col-sm-3"><!--left col-->
   <?php echo "<img src='Assets/imgs/users/".$avatar."' width=100 height=100 class='profilePhoto' id='settingProfile' />"; ?>
              <ul class="list-group">
                <li class="list-group-item text-muted">Profile</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> <?php echo $forename; ?> <?php echo $surname; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Followers</strong></span> <?php echo $followers; ?></li>
              </ul> 
                   <br>
              
              
              <ul class="list-group">
                <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Shares</strong></span> 125</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Likes</strong></span> <?php echo $likes; ?></li>
                <li class="list-group-item text-right"><span class="pull-left"><strong>Posts</strong></span> <?php echo $posts; ?></li>

              </ul> 
                   
              <br>
              
  <a href="logout.php" class="btn btn-danger btn-block">Logout</a>
            </div><!--/col-3-->
          <div class="col-sm-9">
          <div class="form-group">
                              
                              <div class="col-xs-6">
                                  <h4>Change Profile Picture</h4><br>
                                  <form class="btn btn-light" action = "" method = "POST" enctype = "multipart/form-data">
                                  <input type = "file" name = "image"/>
                                  <input class="btn btn-secondary" type = "submit" value="Update Profile Picture"/>
                                </form>
                              </div>
                          </div>
                      <form class="form" action="##" method="post" id="registrationForm">
                        <hr>
                        <h4>Edit other user Details</h4>
                          <div class="form-group">
                              
                              <div class="col-xs-6">
                                  <label for="first_name"><h5>First name</h5></label>
                                  <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $forename; ?>" title="enter your first name if any.">
                              </div>
                          </div>
                          <div class="form-group">
                              
                              <div class="col-xs-6">
                                <label for="last_name"><h5>Last name</h5></label>
                                  <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $surname; ?>" title="enter your last name if any.">
                              </div>
                          </div>
              
                          <div class="form-group">
                              
                              <div class="col-xs-6">
                                  <label for="username"><h5>Username</h5></label>
                                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" >
                              </div>
                          </div>

                          <div class="form-group">
                              
                              <div class="col-xs-6">
                                  <label for="userid"><h5>User ID</h5></label>
                                  <input type="text" class="form-control" name="username" id="username" value="<?php echo $userid; ?>" disabled>
                              </div>
                          </div>
            
                          <div class="form-group">
                              
                              <div class="col-xs-6">
                                  <label for="email"><h5>Email</h5></label>
                                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" title="enter your email.">
                              </div>
                          </div>
                          <div class="form-group">
                               <div class="col-xs-12">
                                    <button class="btn btn-secondary" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Update Details</button>
                                </div>
                          </div>
                    </form>
                  </div>
    
            </div>
  </div> 	
  </div>
  </div>
</div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <?php include("footer.php"); ?> 
</body>
</html>




