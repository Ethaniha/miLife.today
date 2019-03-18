<?php 

session_start();
include("db.php");

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

$sql = "SELECT User_ID, username, forename FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];
$forename = $row[2];

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


$sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes FROM users, post, followers WHERE post.user_id = followers.user_id AND users.user_id = post .user_id AND follower_id = '$user_id' ORDER BY `post`.`posted_at` DESC";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$posts = "";

/*while ($row = mysqli_fetch_array($result)) {
  $posts .= "<div class='jumbotron'>".$row[0]."<br><img src='assets/imgs/users/".$row[3]."' width=100 height=100 /> <br> <br><b>" .$row[2]."</b>: ".$row[1]."<hr></div></br>";
}*/

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
    $posts .= "
    <div class='post'>
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
          <div class='postContent'>
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
      $posts .= "
      <div class='post'>
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
            <div class='postContent'>
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
  <p id="feedCaption">Here are all the updates since you last logged in</p>
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
  <?php include("footer.php"); ?>
  </body>
</html>




