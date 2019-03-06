<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID, username, forename FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];
$forename = $row[2];

if (isset($_GET['postid'])) {
  $postid = $_GET['postid'];

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

$sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes FROM users, post, followers WHERE post.user_id = followers.user_id AND users.user_id = post .user_id AND follower_id = '$user_id' ORDER BY `post`.`posted_at` DESC";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$posts = "";

/*while ($row = mysqli_fetch_array($result)) {
  $posts .= "<div class='jumbotron'>".$row[0]."<br><img src='assets/imgs/users/".$row[3]."' width=100 height=100 /> <br> <br><b>" .$row[2]."</b>: ".$row[1]."<hr></div></br>";
}*/

while ($row = mysqli_fetch_array($result)) {
  $postid = $row[0];
  $sql = "SELECT post_id FROM post_likes WHERE post_id=$postid and user_id=$user_id";
  $result2 = mysqli_query($db, $sql) or die(mysqli_error($db));
  if (mysqli_num_rows($result2) < 1) {
    $posts .= "<div class='jumbotron'>".$row[1]."<br><img src='assets/imgs/users/".$row[4]."' width=100 height=100 /> <br> <br><b>" .$row[3]."</b>: ".$row[2]."<hr>
              <form action='index.php?&postid=".$row[0]."' method='post'>
                <input type='submit' name='like' value='Like'>
              </form>
              Likes: " .$row[5]."

    </div></br>";
  } else {
      $posts .= "<div class='jumbotron'>".$row[1]."<br><img src='assets/imgs/users/".$row[4]."' width=100 height=100 /> <br> <br><b>" .$row[3]."</b>: ".$row[2]."<hr>
              <form action='index.php?&postid=".$row[0]."' method='post'>
                <input type='submit' name='like' value='Unlike'>
              </form>
              Likes: " .$row[5]."

    </div></br>";
  }
}

if ($myusername==''){
  header("Location: login.php"); /* Redirect browser */
  exit();
 }

?> 

<html>
   
  <head>
    <title>miLIFE | Home</title>
      
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <?php include("head.php"); ?>

<div id="feedHeader" class="jumbotron" >
    <div class="container">
  <h1 class="display-2">Welcome, <?php echo $forename; ?></h1>
  <p class="lead">This is your main feed</p>
</div>
</div>
  <div class="container">
    <div class="row">
    <div class="col-md">
      <div class="jumbotron"><br>
      </div>
    </div>
    <div class="col-md-6">
    <?php echo $posts; ?>
    </div>
    <div class="col-md">
      <div class="jumbotron"><br><br><br><br><br>
      </div>
    </div>
  </div>
  </div>




  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  </body>
</html>




