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
    if(isset($_SESSION['login_user'])){
     $myusername = $_SESSION['login_user'];

    $sql = "SELECT image FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_image = $row[0];
    }

    $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_id = $row[0];

    if(isset($_POST['sendpost'])) {

      if($_FILES['image']['size'] != 0) {
    
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
          move_uploaded_file($file_tmp,"Assets/imgs/posts/".$file_name);
           
    
          $postbody = $_POST['postbody'];
          $time = date("Y-m-d H:i:s");
    
          $sql = "INSERT INTO post (body, posted_at, user_id, likes, image) VALUES ('$postbody', '$time', '$user_id', 0, '$file_name')";
          $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    
        }
    
      }
      else if (!empty($errors)) {
        print_r($errors);
      }
      else {
        $postbody = $_POST['postbody'];
        $time = date("Y-m-d H:i:s");
    
        $sql = "INSERT INTO post (body, posted_at, user_id, likes) VALUES ('$postbody', '$time', '$user_id', 0)";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      }
    
    }
  }
  ?>
  <link rel="stylesheet" href="css/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <nav class="navbar navbar-expand-sm bg-light navbar-light">

    <div class="container">
      <div class="navbar-leftside">
   <a href="index.php"><img src="../Assets/logo.png" alt="Logo" id="navbar-logo"></a>
  </div>
<?php if(isset($_SESSION['login_user'])) {
    echo'
    <div class="navbar-center">
      <form action="" method="post" class="d-inline w-100 form-inline mx-auto my-auto">

        <div class="searchbox">
          <input class="form-control" id="search-input" type="text" placeholder="Search for someone..." autocomplete="off">
          <ul class="list-group autocomplete" id="searchresult" style="position:absolute;width:100%; z-index: 101">
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
      <a href="messages.php"><i class="fas fa-comment-alt navbar-icon" ></i></a>
      </li>
      <li>
      <a href="user_settings.php"><i class="fas fa-cog navbar-icon" ></i></a>
      </li>
      <li>
      <i class="fas fa-plus navbar-icon" id="navbar-addpost-icon" data-toggle="modal" data-target="#addPost"></i>
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

  <div class="modal fade" id="addPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Add a new post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post" enctype="multipart/form-data">
      <textarea  class="form-control" name="postbody" rows="5" cols="80"></textarea>
      <br>
      <input type = "file" name = "image" class="btn btn-light">
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="sendpost" value="Post!" class="btn btn-primary">
      </div>
      </form>
    </div>
  </div>
</div>

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
