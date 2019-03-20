<?php 
session_start();
include ("db.php");

function notify($body, $id, $type, $db) {

  if ($type == 2) {
    $sql = "SELECT post.user_id FROM post, post_likes WHERE post.post = post_likes.post_id";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $receiverID = $row[0];

    $myusername = $_SESSION['login_user'];
    $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_id = $row[0];

    $sql = "INSERT INTO notifications (type, sender_id, receiver_id, post_id) VALUES (2, '$user_id', '$receiverID', '$id')";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  }
  else if ($type == 3) {
    $sql = "SELECT user_id FROM users_comments WHERE id = '$id' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $receiverID = $row[0];

    $myusername = $_SESSION['login_user'];
    $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $user_id = $row[0];

    $sql = "INSERT INTO notifications (type, sender_id, receiver_id, post_id) VALUES (3, '$user_id', '$receiverID', '$id')";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  }


}

function addMention($post) {
$body = explode(" ", $post);
$newBody = "";

foreach ($body as $word) {
  if (substr($word,0,1) == "@")
  {
    $link = str_replace("@","",$word);
    $newBody .= "<a href='user_profile.php?username=".$link."'>".$word." </a>";
  } 
  else 
  {
    $newBody .= $word." ";
  }
}

return $newBody;
}

$myusername = $_SESSION['login_user'];

$sql = "SELECT username FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$current_username = $row[0];

if (isset($_GET['username'])) {

  $username = $_GET['username'];

  if ($username == ""){
    $username = $current_username;
  }

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





// $sql = "SELECT * FROM post where user_id = $user_id";
// $result = mysqli_query($db, $sql) or die(mysqli_error($db));

// $posts = "";

if (isset($_GET['postid'])) {
  $postid = $_GET['postid'];

  if (isset($_POST['comment'])) {

    $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $commenter_id = $row[0];

    $commentbody = $_POST['commentbody'];
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users_comments (body, user_id, posted_at, post_id) VALUES ('$commentbody', '$commenter_id', '$time', '$postid' )";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  }
  
  if (isset($_POST['like'])) {
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

  $commentsql = "SELECT users_comments.body, users.username, users.image FROM users_comments, users WHERE post_id = $postid AND users_comments.user_id = users.User_ID";
  $commentresult = mysqli_query($db, $commentsql) or die(mysqli_error($db));

  $postBody = addMention($row[2]);

  while ($commentrow = mysqli_fetch_array($commentresult)) {
    $comments .= "<div class='row comment'><div class='col-xs-2'><img src='../Assets/imgs/users/".$commentrow[2]."'class='profilePhoto'/></div><div class='col-xs-10 postCommentDetail'><b>".$commentrow[1]."</b><br>".$commentrow[0]."</br></div></div>";
  }
  
  if (mysqli_num_rows($result2) < 1) {

    if(is_null($row[6])) {
      $img = "";
    } 
    else {
      $img = "<br><img src='/Assets/imgs/posts/".$row[6]."' height=400/><br>";
    }

    $posts .= "
    <div class='post' id='profilePost'>
      <div class='container'>
        <div class='row'>
            <div class='col-xs-3'>
              <img src='../Assets/imgs/users/".$row[4]."' class='profilePhoto'/>
            </div>
            <div class='col-xs-9 postDetails'>
              <b><a href='user_profile.php?username=$row[3]'>" .$row[3]."</a></b>
              <p><i class='far fa-clock'></i> ".$row[1]."</p>
            </div>
          </div>
        <div class='row'>
          <div class='postContent'>".$img."
          <h2 class='postText'>".$postBody."</h2>
          </div>
        </div>
          <hr>
          <div class='col-xs-10'>
            <form action='index.php?&postid=".$row[0]."' method='post'>
            <button type='submit' class='btn btn-secondary' name='like'>
                <i class='fas fa-heart'></i>
              </button>
              </form>
          </div>
          <div class='col-xs-2'>
          <p>Likes: " .$row[5]."</p>
        </div>
        <form action='index.php?postid=".$row[0]."' method='post'>
        <div class='input-group mb-3'><input type='text' class='form-control' placeholder='Write a comment...' name='commentbody' rows='3' cols='40'></textarea>
        <div class='input-group-append'><button type='submit' name='comment' value='Comment!' class='btn btn-secondary'>Post</button>
        </div>
        </div>
      </form>
      <div class='postComments'>".$comments."</div>
      </div>
    </div></br>";
  } else {

    if(is_null($row[6])) {
      $img = "";
    } 
    else {
      $img = "<br><img src='/Assets/imgs/posts/".$row[6]."' height=400/><br>";
    }
    $posts .= "
    <div class='post' id='profilePost'>
      <div class='container'>
        <div class='row'>
            <div class='col-xs-3'>
              <img src='../Assets/imgs/users/".$row[4]."' class='profilePhoto'/>
            </div>
            <div class='col-xs-9 postDetails'>
              <b><a href='user_profile.php?username=$row[3]'>" .$row[3]."</a></b>
              <p><i class='far fa-clock'></i> ".$row[1]."</p>
            </div>
          </div>
        <div class='row'>
          <div class='postContent'>".$img."
          <h2 class='postText'>".$postBody."</h2>
          </div>
        </div>
          <hr>
          <div class='col-xs-10'>
            <form action='index.php?&postid=".$row[0]."' method='post'>
            <button type='submit' class='btn btn-danger' name='like'>
                <i class='fas fa-heart'></i>
              </button>
              </form>
          </div>
          <div class='col-xs-2'>
          <p>Likes: " .$row[5]."</p>
        </div>
        <form action='index.php?postid=".$row[0]."' method='post'>
        <div class='input-group mb-3'><input type='text' class='form-control' placeholder='Write a comment...' name='commentbody' rows='3' cols='40'></textarea>
        <div class='input-group-append'><button type='submit' name='comment' value='Comment!' class='btn btn-secondary'>Post</button>
        </div>
        </div>
      </form>
      <div class='postComments'>".$comments."</div>
      </div>
    </div></br>";
  }
}

if($myusername == $email){
  $whosProfile = 'My';
}else{
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
    <div class="row">
<div class="col-md-3">
<?php echo "<img src='/Assets/imgs/users/".$avatar."' id='profilePagePhoto'/>"; ?>
</div>
<div class="col-md-4">
<h2 id="profileHeader"><?php echo $whosProfile;?> Profile</h2>

<b>Forename: </b><?php echo $forename; ?><br>

<b>Surname: </b><?php echo $surname; ?><br>

<b>Email: </b><?php echo $email; ?><br>

<b>Followers: </b><?php echo $followers; ?><br>
<form action="" method="post" >
      <input type="submit" name="follow" value="Follow" class="btn btn-primary" id="followButton">
</form>
</div></div>




<h5 class="sectionHeader"><?php echo $whosProfile;?> Posts</h5>
<p>(in chronological order)</p>

    <?php echo $posts; ?>
  </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <?php include("footer.php"); ?>
  </body>
</html>




