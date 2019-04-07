<?php
  
  include("db.php");

   session_destroy();
   session_start();
   
   if(isset($_POST["submit"])) {
      // username and password sent from form 

      $myusername = mysqli_real_escape_string($db,$_POST['email']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT User_ID, username, password FROM users WHERE email = '$myusername'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result);

      $hashedPass = password_hash($mypassword, PASSWORD_DEFAULT);
      $checkPass = password_verify($mypassword, $hashedPass);


      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
      if($count == 1 && $checkPass == 1) {
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
      <link rel="stylesheet" href="CSS/main.css">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
   </head>
   
    <body id="loginBody" bgcolor = "#000000">

    <?php include("head.php"); ?>
    
<div id="signin">
    <form class="form-signin" action="" method="post">
  <img class="mb-4" src="../Assets/logo.png" alt="" id="milife-logo" width="72" height="72">
  <h1 class="mb-3 font-weight-normal signinH1">Sign in to miLife</h1>
  <label  for="inputEmail" class="sr-only" name="username">Email address</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
  <label  for="inputPassword" class="sr-only" name="password">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
  <div class="checkbox mb-3">
    <label class="signinH1">
      <input type="checkbox" value="remember-me" name="remember"> Remember Me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
  <br>
   <p class="signinH1"><a class="signinH1" href="register.php">Or click here to register</a></p>
   <?php if (!empty($error)) { echo '
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>'.$error.'</strong>  
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
   </div>';}?>
</form>
</div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
if (navigator.platform.substr(0,2) === 'iP'){
   //iOS (iPhone, iPod or iPad)
   var lte9 = /constructor/i.test(window.HTMLElement);
   var nav = window.navigator, ua = nav.userAgent, idb = !!window.indexedDB;
   if (ua.indexOf('Safari') !== -1 && ua.indexOf('Version') !== -1 && !nav.standalone){      
      //Safari (WKWebView/Nitro since 6+)
   } else if ((!idb && lte9) || !window.statusbar.visible) {
      //UIWebView
   } else if ((window.webkit && window.webkit.messageHandlers) || !lte9 || idb){
      //WKWebView
      document.getElementById("milife-logo").src="../Assets/applogo.png";
   }
}
</script>
   </body>
</html>