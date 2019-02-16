<?php 
session_start();
include ("db.php");

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

    $myusername = $_SESSION['login_user'];

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
      echo "You are already following this user";
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

  $postbody = $_POST['postbody'];
  $time = date("Y-m-d H:i:s");

  $sql = "INSERT INTO post (body, posted_at, user_id, likes) VALUES ('$postbody', '$time', '$user_id', 0)";
  $result = mysqli_query($db, $sql) or die(mysqli_error($db));

}

$sql = "SELECT * FROM post where user_id = $user_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));

$posts = "";

while ($row = mysqli_fetch_array($result)) {
  $posts .= $row[1]."<hr></br>";
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


    <table class="table-sm">
    <tr>
      <td><?php echo "<img src='images/users/".$avatar."' width=100 height=100 />"; ?></td><td></td>
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

    <form action="" method="post">
      <input type="submit" name="follow" value="Follow">
    </form>

    <form action="" method="post">
      <textarea name="postbody" rows="5" cols="80"></textarea>
      <input type="submit" name="sendpost" value="Post!">
    </form>

    <?php echo $posts; ?>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>



  </body>
</html>




