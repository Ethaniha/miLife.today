<?php


    include("db.php");

   session_start();
  
    if(isset($_POST["submit"])) {

        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $email= $_POST['email'];
        $pass = $_POST['password'];

        $forename = mysqli_real_escape_string($db,$forename);
        $surname = mysqli_real_escape_string($db,$surname);
        $email = mysqli_real_escape_string($db,$email);

        $sql="SELECT email FROM users WHERE email='$email'";
        $result=mysqli_query($db,$sql);
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        if(mysqli_num_rows($result) == 1)
        {
          $msg = "Sorry...This email already exist...";
        }
        else
        {
          $query = mysqli_query($db, "INSERT INTO users (forename, surname, email, password)VALUES ('$forename', '$surname', '$email', '$pass')");
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
      <h2>Register</h2>
      <form action="" method="post">

        <div class="form-row">

          <div class="form-group col-md-3">
            <label for="inputEmail4">Forename:</label>
            <input type="text" class="form-control" id="forename" placeholder="forename" name="forename">
          </div>

          <div class="form-group col-md-3">
            <label for="inputEmail4">Forename:</label>
            <input type="text" class="form-control" id="surname" placeholder="surname" name="surname">
          </div>

        </div>

        <div class="form-group">
          <label class="control-label" name="username">Email:</label>
          <input type="email" class="form-control" placeholder="Enter email" name="email">
        </div>

        <div class="form-group">
          <label class="control-label" name="password">Password:</label>     
            <input type="password" class="form-control" name="password" placeholder="Enter password">
        </div>

        <div class="form-group">        
            <div class="checkbox">
              <label><input type="checkbox" name="remember"> Remember me</label>
            </div>
        </div>

        <div class="form-group">        
          <div class="col-sm-offset-2">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
          </div>
        </div>
        Or click <a href="register.php">here</a> to register
      </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

   </body>
</html>