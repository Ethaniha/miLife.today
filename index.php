<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID, username FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

$sql = "SELECT post.body, users.username, users.image FROM users, post, followers WHERE post.user_id = followers.user_id AND users.user_id = post.user_id AND follower_id = '$user_id' ";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));

$posts = "";

while ($row = mysqli_fetch_array($result)) {
  $posts .= "<img src='images/users/".$row[2]."' width=100 height=100 />".$row[1].": ".$row[0]."<hr></br>";
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

  <div class="container">

    <?php echo $posts; ?>

  </div>




  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  </body>
</html>




