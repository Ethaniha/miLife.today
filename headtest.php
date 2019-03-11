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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <nav class="navbar navbar-expand-sm bg-light navbar-light">

    <div class="container">
      <div class="navbar-leftside">
   <a href="index.php" ><img src="../Assets/logo.png" alt="Logo" id="navbar-logo"></a>
  </div>
<?php if(isset($_SESSION['login_user'])) {
    echo'
    <div class="navbar-center">
      <form action="" method="post" class="d-inline w-100 form-inline mx-auto my-auto">

        <div class="searchbox">
          <input class="form-control" id="search-input" type="text">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Search</button>
          </div>
          <ul class="list-group autocomplete" id="searchresult" style="position:absolute;width:100%; z-index: 100">
          </ul>
        </div>

      </form>
    </div>'; } ?>


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

<script>
  $(document).ready(function(){

   load_data();

   function load_data(query)
   {
    $.ajax({
     url:"search.php",
     method:"POST",
     data:{query:query},
     success:function(data)
     {
      $('#searchresult').html(data);
      console.log(data);
     }
    });
   }
   $('#search-input').keyup(function(){
    var search = $(this).val();
    if(search != '')
    {
     load_data(search);
    }
    else
    {
     load_data();
    }
   });
  });
</script>
