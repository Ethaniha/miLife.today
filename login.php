<?php
  
  include("db.php");

   session_start();
   
   if(isset($_POST["submit"])) {
      // username and password sent from form 

      $myusername = mysqli_real_escape_string($db,$_POST['email']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT User_ID, username FROM users WHERE email = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result);

      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['username'] = $row[1];
         
         header("location: index.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
   </head>
   
    <body bgcolor = "#FFFFFF">

    <?php include("head.php"); ?>
    
<div id="signin">
    <form class="form-signin" action="" method="post">
  <img class="mb-4" src="assets/logo.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only" name="username">Email address</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
  <label for="inputPassword" class="sr-only" name="password">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me" name="remember"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
          Or click <a href="register.php">here</a> to register
        <?php if (!empty($error)) { echo $error; } ?>
  <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
</form>
</div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

   </body>
</html>