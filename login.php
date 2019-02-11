<?php
   define('DB_SERVER', 'localhost:3306');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'password');
   define('DB_DATABASE', 'socialmedia');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT User_ID FROM users WHERE email = '$myusername' and password = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         
         header("location: homepage.php");
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

    <nav class="navbar navbar-expand-sm bg-light navbar-light">

      <a class="navbar-brand" href="#">
        <img src="logo.png" alt="Logo">
      </a>

      <form class="form-inline mx-auto  my-auto" action="/action_page.php">
              <div class="input-group">
                  <input class="form-control py-2 border-right-0 border" type="Search for something.." value="search" id="example-search-input">
                  <span class="input-group-append">
                      <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                  </span>
              </div>
      </form>


      <ul class="navbar-nav">
        <li class="nav-item">
          <i class="fas fa-bell fa-2x" data-count="2" style="color:grey"></i>
        </li>
        <li class="nav-item">
          <i class="fas fa-cogs fa-2x" style="color:grey"></i>
        </li>
        <li class="nav-item">
          <a href="login.php"<<i class="fas fa-user fa-2x" style="color:grey"></i></a>
        </li>
      </ul>
    </nav>
    
    <div class="container">
      <h2>Log-in</h2>
      <form class="form-horizontal" action="" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2" name="username">Email:</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" name="username" placeholder="Enter email" name="email">
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" name="password">Password:</label>
          <div class="col-sm-10">          
            <input type="password" class="form-control" name="password" placeholder="Enter password" name="pwd">
          </div>
        </div>
        <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
          </div>
        </div>
        <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Submit</button>
          </div>
        </div>
        Or click <a href="register.php">here</a> to register
      </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

   </body>
</html>