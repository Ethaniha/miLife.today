  <?php 
    if(isset($_POST['search'])) {
      $search = $_POST['input'];

      $sql = "SELECT username FROM users WHERE username LIKE '%$search%' ";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      $row = mysqli_fetch_array($result);

      if (is_null($row[0])) {
        echo "no user found";
      }
      else {
        header("Location: user_profile.php?username=".$row[0]);
        die();
      }

      
    }
    if(isset($_SESSION['login_user'])){
     $myusername = $_SESSION['login_user'];

    $sql = "SELECT image FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_image = $row[0];
    }
  ?>
  <link rel="stylesheet" href="css/main.css">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <nav class="navbar navbar-expand-sm bg-light navbar-light">

    <div class="container">
      <div class="navbar-leftside">
   <a href="index.php" ><img src="assets/logo.png" alt="Logo" id="navbar-logo"></a>
  </div>
<?php if(isset($_SESSION['login_user'])) {
    echo'<div class="navbar-center">
    <form action="" method="post" class="d-inline w-100 form-inline mx-auto my-auto">
            <div class="input-group">
                <input class="form-control py-2 border" type="Search for something.." placeholder="Search for something.." id="search-input" name="input">
                <span class="input-group-append">
                    <button type="submit" class="input-group-text bg-transparent" name="search"><i class="fa fa-search"></i></button>
                </span>
            </div>
    </form></div>'; } ?>


    <ul class="navbar-nav navbar-rightside ">
<?php if(isset($_SESSION['login_user'])) {
      echo '<li class="ml-auto">
        <i class="fas fa-bell navbar-icon" data-count="2"  ></i>
      </li>
      <li>
        <a href="user_settings.php"><i class="fas fa-cog navbar-icon" ></i></a>
      </li>
      <li  >
      <a href=""><i class="fas fa-plus navbar-icon" id="navbar-addpost-icon"></i></a>
      </li>
      <li>
      <a href="user_profile.php?username='.$_SESSION['username'].'"><i class="navbar-icon" id="navbar-profile-icon" style="background-image: url(Assets/imgs/users/'.$user_image.') !important;" ></i> </a>
      </li>';
    }  else {
          echo '<li class="ml-auto" ><a href="login.php"><i class="fas fa-user navbar-icon"></i></a></li>';
        } ?>  
        </ul>
    </div>
  </nav>
