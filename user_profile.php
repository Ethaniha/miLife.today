<?php 
session_start();
include ("db.php");

$myusername = $_SESSION['login_user'];

if (isset($_GET['username'])) {

  $username = $_GET['username'];

  $sql = "SELECT User_ID, Email, Forename, Surname, image FROM users WHERE username = '$username' ";
  $result = mysqli_query($db, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row=mysqli_fetch_array($result)) {

      $email = $row[1];
      $forename = $row[2];
      $surname = $row[3];
      $avatar = $row[4];
    }
  } 
  else 
  {
    //echo "user doesn't exist";
  }

}
else {
  //echo "not set";
}

if (isset($_POST['follow'])) {



    $sql = "SELECT User_ID FROM users WHERE username = '$username' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_id = $row[0];

    $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $follower_id = $row[0];

    $sql = "SELECT id FROM followers WHERE user_id = '$user_id' AND follower_id = '$follower_id' ";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) == 1) {
      echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
You are already following '.$username.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
    }
    else {
      $sql = "INSERT INTO followers (user_id, follower_id) VALUES ($user_id, $follower_id)";
      $result = mysqli_query($db, $sql);

      //echo "user followed";
    }

}

/////////////////

  $sql = "SELECT User_ID FROM users WHERE username = '$username' ";
  $result = mysqli_query($db, $sql);
  $row=mysqli_fetch_array($result);
  $user_id = $row[0];

  $sql = "SELECT id FROM followers WHERE user_id = '$user_id' ";
  $result = mysqli_query($db, $sql);
  $followers = mysqli_num_rows($result);

/////////////////


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


// $sql = "SELECT * FROM post where user_id = $user_id";
// $result = mysqli_query($db, $sql) or die(mysqli_error($db));

// $posts = "";

if (isset($_GET['postid'])) {
  $postid = $_GET['postid'];

  if (isset($_POST['comment'])) {
    $commentbody = $_POST['commentbody'];
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users_comments (body, user_id, posted_at, post_id) VALUES ('$commentbody', '$user_id', '$time', '$postid' )";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  }
  else {
    $sql = "SELECT user_id FROM post_likes WHERE post_id= $postid AND user_id= $user_id";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    if (mysqli_num_rows($result) < 1) {
      $sql = "UPDATE post SET likes = likes + 1 WHERE post = $postid";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      $sql = "INSERT INTO post_likes (post_id, user_id) VALUES ($postid, $user_id)";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    } else {
      $sql = "UPDATE post SET likes = likes - 1 WHERE post = $postid";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      $sql = "DELETE FROM post_likes WHERE post_id = $postid AND user_id = $user_id";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    }
  }
}

$sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes, post.image FROM users, post WHERE users.user_id = post.user_id AND post.user_id = $user_id ORDER BY `post`.`posted_at` DESC";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$posts = "";

while ($row = mysqli_fetch_array($result)) {
  $postid = $row[0];
  $comments = "";
  $sql = "SELECT post_id FROM post_likes WHERE post_id=$postid and user_id=$user_id";
  $result2 = mysqli_query($db, $sql) or die(mysqli_error($db));

  $commentsql = "SELECT users_comments.body, users.username FROM users_comments, users WHERE post_id = $postid AND users_comments.user_id = users.User_ID";
  $commentresult = mysqli_query($db, $commentsql) or die(mysqli_error($db));

  while ($commentrow = mysqli_fetch_array($commentresult)) {
    $comments .= "<b>".$commentrow[1]."</b>: ".$commentrow[0]."</br>";
  }

  if (mysqli_num_rows($result2) < 1) {
    if(is_null($row[6])) {
      $img = "";
    } 
    else {
      $img = "<br><img src='/Assets/imgs/posts/".$row[6]."' height=400/><br>";
    }

    $posts .= "<div class='jumbotron'>".$row[1]."<br><img src='/Assets/imgs/users/".$row[4]."' width=100 height=100 />  <br> <br><b>" .$row[3]."</b>: "  
      .$img.$row[2]."<hr>
              <form action='user_profile.php?username=$username&postid=".$row[0]."' method='post'>
                <input type='submit' name='like' value='Like'>
              </form>
              Likes: " .$row[5]."

              <form action='user_profile.php?username=$username&postid=".$row[0]."' method='post'>
                <textarea  class='form-control' name='commentbody' rows='3' cols='40'></textarea>
                <input type='submit' name='comment' value='Comment!' class='btn btn-light'>
              </form>"

              .$comments."

    </div></br>";
  } else {
      $posts .= "<div class='jumbotron'>".$row[1]."<br><img src='/Assets/imgs/users/".$row[4]."' width=100 height=100 /> <br> <br><b>" .$row[3]."</b>: "
        .$img.$row[2]."<hr>
              <form action='user_profile.php?username=$username&postid=".$row[0]."' method='post'>
                <input type='submit' name='like' value='Unlike'>
              </form>
              Likes: " .$row[5]."

              <form action='user_profile.php?username=$username&postid=".$row[0]."' method='post'>
                <textarea  class='form-control' name='commentbody' rows='3' cols='40'></textarea>
                <input type='submit' name='comment' value='Comment!' class='btn btn-light'>
              </form>"

              .$comments."

    </div></br>";
  }
}

if($myusername == $email){
  $newPostBox = '<form action="" method="post" enctype="multipart/form-data">
      <textarea  class="form-control" name="postbody" rows="5" cols="80"></textarea>
      <input type = "file" name = "image" class="btn btn-light">
      <input type="submit" name="sendpost" value="Post!" class="btn btn-light">
    </form>';
  $whosProfile = 'My';
}else{
  $newPostBox = '';
  $whosProfile = $forename."'s";
}


?>

<html>
   
  <head>

    <title>miLIFE | <?php echo $forename. ' ' .$surname ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
  </head>
   
  <body bgcolor = "#FFFFFF">
      
    <?php include("head.php"); ?>

<div class="container">
  <h2 class="pageHeader"><?php echo $whosProfile;?> Profile</h2>
    <table class="table-sm">
    <tr>
      <td><?php echo "<img src='/Assets/imgs/users/".$avatar."' width=100 height=100 />"; ?></td><td></td>
    </tr>
    <tr>
      <td>Forename:</td><td><?php echo $forename; ?></td>
    </tr>
    <tr>
      <td>Surname:</td><td><?php echo $surname; ?></td>
    </tr>
    <tr>
      <td>Email:</td><td><?php echo $email; ?></td>
    </tr>
    <tr>
      <td>Followers:</td><td><?php echo $followers; ?></td>
    </tr>
    </table>

<form action="" method="post" >
      <input type="submit" name="follow" value="Follow" class="btn btn-primary">
</form>


<?php echo $newPostBox;?>


<h5 class="sectionHeader"><?php echo $whosProfile;?> Posts</h5>
<p>(in reverse chronological order)</p>

    <?php echo $posts; ?>
  </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>


  </body>
</html>




