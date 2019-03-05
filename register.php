<?php


    include("db.php");

   session_start();
  
    if(isset($_POST["submit"])) {

        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email= $_POST['email'];
        $pass = $_POST['password'];

        $forename = mysqli_real_escape_string($db,$forename);
        $surname = mysqli_real_escape_string($db,$surname);
        $email = mysqli_real_escape_string($db,$email);
        $username = mysqli_real_escape_string($db,$username);

        $sql="SELECT email FROM users WHERE email='$email'";
        $resultemail=mysqli_query($db,$sql);
        $row=mysqli_fetch_array($resultemail,MYSQLI_ASSOC);

        $sql="SELECT username FROM users WHERE username='$username'";
        $resultuser=mysqli_query($db,$sql);
        $row=mysqli_fetch_array($resultuser,MYSQLI_ASSOC);

        if(mysqli_num_rows($resultemail) == 1)
        {
          $msg = "Sorry...This email already exist...";
        }
        elseif(mysqli_num_rows($resultuser) == 1) {
          $msg = "Sorry...This username already exist...";
        }
        else
        {
          $query = mysqli_query($db, "INSERT INTO users (forename, surname, email, username, password)VALUES ('$forename', '$surname', '$email', '$username', '$pass')");
          if($query)
          {
            $msg = "Thank You! you are now registered.";
          }
        }
      }

?>
<html>
   
   <head>
      <title>Register Page</title>
      
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
   </head>
   
    <body bgcolor = "#FFFFFF">

    <?php include("head.php"); ?>
    
<div id="signin">
    <form class="form-signin" id="form-register" action="" method="post">

        <img class="mb-4" src="assets/logo.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Register for miLIFE</h1>
        <div class="form-row">

          <div class="form-group col-md-6">
            <label class="sr-only" for="inputEmail4">Forename:</label>
            <input type="text" class="form-control" id="forename" placeholder="forename" name="forename">
          </div>

          <div class="form-group col-md-6">
            <label class="sr-only" for="inputEmail4">Surname:</label>
            <input type="text" class="form-control" id="surname" placeholder="surname" name="surname">
          </div>

        </div>

        <div class="form-group">
          <label class="control-label sr-only" name="username">Username:</label>
          <input type="username" class="form-control" placeholder="Enter username" name="username">
        </div>

        <div class="form-group">
          <label class="control-label sr-only" name="username">Email:</label>
          <input type="email" class="form-control" placeholder="Enter email" name="email">
          <label class="control-label sr-only" name="password">Password:</label>     
            <input type="password" class="form-control" name="password" placeholder="Enter password">
        </div>

        <div class="form-group">        
            <div class="checkbox">
              <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
        </div>

        <div class="form-group">        
          <div class="col-sm-offset-2">
            <button type="submit" class="btn btn-lg btn-primary btn-block" name="submit">Submit</button>
          </div>
        </div>
        Or click <a href="login.php">here</a> to login with an existing Account
        <?php if (!empty($msg)) { echo $msg; } ?>
          <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
      </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

   </body>
</html>