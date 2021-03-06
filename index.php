<?php 

session_start();
include("db.php");

  function notify($body, $id, $type, $db) {

    if ($type == 2) {

      $myusername = $_SESSION['login_user'];
      $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
      $result = mysqli_query($db, $sql);
      $row=mysqli_fetch_array($result);
      $user_id = $row[0];


      $sql = "SELECT post.user_id FROM post
      JOIN post_likes ON post.post = post_likes.post_id WHERE post_likes.id = '$id' AND post.user_id != '$user_id'";
      $result = mysqli_query($db, $sql);
      $row = mysqli_fetch_array($result);
      $receiverID = $row[0];


      $sql = "INSERT INTO notifications (type, sender_id, receiver_id, post_id) VALUES (2, '$user_id', '$receiverID', '$id')";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    }
    else if ($type == 3) {
      
      $myusername = $_SESSION['login_user'];
      $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
      $result = mysqli_query($db, $sql);
      $row=mysqli_fetch_array($result);
      $user_id = $row[0];


      $sql = "SELECT post.user_id FROM post
      JOIN users_comments ON post.post = users_comments.post_id WHERE users_comments.id = '$id' AND post.user_id != '$user_id'";
      $result = mysqli_query($db, $sql);
      $row = mysqli_fetch_array($result);
      $receiverID = $row[0];


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

$sql = "SELECT User_ID, username, forename FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];
$forename = ucwords($row[2]);

if (isset($_GET['postid'])) {

  $postid = $_GET['postid'];

  if (isset($_POST['comment'])) {
    $commentbody = $_POST['commentbody'];
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users_comments (body, user_id, posted_at, post_id) VALUES ('$commentbody', '$user_id', '$time', '$postid' )";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    $last_row = mysqli_insert_id($db);
    notify("", $last_row, 3, $db);
  }
  else {

    $sql = "SELECT user_id FROM post_likes WHERE post_id= $postid AND user_id= $user_id";
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    if (mysqli_num_rows($result) < 1) {
      $sql = "UPDATE post SET likes = likes + 1 WHERE post = $postid";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));

      $sql = "INSERT INTO post_likes (post_id, user_id) VALUES ('$postid', '$user_id' )";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      $last_row = mysqli_insert_id($db);
      notify("", $last_row, 2, $db);

    } else {
      $sql = "UPDATE post SET likes = likes - 1 WHERE post = $postid";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
      $sql = "DELETE FROM post_likes WHERE post_id = $postid AND user_id = $user_id";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));

    }
  }

}

$sql = "SELECT users.image, users.forename, users.username  FROM users, followers WHERE users.user_id = followers.user_id AND followers.follower_id = '$user_id' AND followers.follower_id != followers.user_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$friends = "";

if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_array($result)) {
  $friends .= '<div class="friend"><a href="user_profile.php?username='.$row[2].'">
                <div class="container">
                  <div class="row">
                  <div class="col-xs-2">
                  <div style="background-image: url(Assets/imgs/users/'.$row[0].') !important;" class="profilePhoto"></div>
                  </div>
                  <div class="col-xs-10 friendDetails">
                  <b>'.ucwords($row[1]).'</b>
                  <p>@'.$row[2].'</p>
                  </div>
                  </div>
                </div></a>
              </div>';
}
} else {
  $friends = '<h6>You are not currenty following anyone</h6>';
}

$sql = "SELECT DISTINCT users.image, users.forename, users.username FROM users
INNER JOIN followers ff ON users.user_id = ff.user_id
INNER JOIN followers f ON ff.follower_id = f.user_id
WHERE
f.follower_id = '$user_id'
AND ff.user_id NOT IN
(SELECT DISTINCT user_id FROM followers WHERE follower_id = '$user_id')
-- AND ff.follower_id NOT IN
-- (SELECT user_id FROM followers WHERE followers.user_id = '$user_id')
";

$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$recomendations = "";
if (mysqli_num_rows($result) > 0) {
while ($row = mysqli_fetch_array($result)) {
  $recomendations .= '<div class="friend"><a href="user_profile.php?username='.$row[2].'">
                <div class="container">
                  <div class="row">
                  <div class="col-xs-2">
                  <div style="background-image: url(Assets/imgs/users/'.$row[0].') !important;" class="profilePhoto"></div>
                  </div>
                  <div class="col-xs-10 friendDetails">
                  <b>'.ucwords($row[1]).'</b>
                  <p>@'.$row[2].'</p>
                  </div>
                  </div>
                </div></a>
              </div>';
}
} else {
  $recomendations = '<h6>In order to gain miLife recomendations, please follow at least one user.</h6>';
}

$sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes, post.type, post.price, post.image, post.user_id FROM users, post, followers WHERE post.user_id = followers.user_id AND users.user_id = post.user_id AND follower_id = '$user_id' ORDER BY `post`.`posted_at` DESC";
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
    $commentBody = addMention($commentrow[0]);
    $comments .= "<div class='row comment'><div class='col-xs-2'><div style='background-image: url(Assets/imgs/users/".$commentrow[2].") !important;' class='profilePhoto'></div></div><div class='col-xs-10 postCommentDetail'><b>".$commentrow[1]."</b><br>".$commentBody."</br></div></div>";
  }


  if (mysqli_num_rows($result2) < 1) {

    if(is_null($row[8])) {
      $img = "<div class='postContent'>
                <h2 class='postText'>".$postBody."</h2>
              </div>";
    } 
    else {
      $img = "<div class='postContentImage'>
                <img src='../Assets/imgs/posts/".$row[8]."' class='postImg'/><br>
                <h2 class='postText'>".$postBody."</h2>
              </div>";
    }

    if ($row[9] == $user_id) {
      $deleteButton = "<button class='delete btn btn-light' data-id='".$row[0]."'><i class='fas fa-trash-alt'></i></button>";
    } else {
      $deleteButton = "";
    }

    $date = date_format(new DateTime($row[1]),"d F Y G:i");
    $price = "";
    if ($row[6] == 1) { $price = "<p style='color: green;'><i class='fas fa-hand-holding-usd'></i> £".$row[7]."</p>" ;} else {$price = "";}
    $posts .= "
    <div class='post' data-aos='fade-up'
    data-aos-duration='400'>
      <div class='container'>
        <div class='row'>
            <div class='col-xs-3'>
            <div style='background-image: url(Assets/imgs/users/".$row[4].") !important;' class='profilePhoto'></div>
            </div>
            <div class='col-xs-8 postDetails'>
              <b><a href='user_profile.php?username=".$row[3]."'>" .$row[3]."</a></b>
              <p><i class='far fa-clock'></i> ".$date."</p>".$price."

            </div>
            <div class='col-xs-1 ml-auto mr-3'>
            ".$deleteButton."
            </div>
          </div>
        <div class='row'>
        ".$img."
        </div>
          <hr>
          <div class='col-xs-10'>
            <button type='submit' class='btn btn-secondary like' name='like' data-id='".$row[0]."''>
                <i class='fas fa-heart'></i>
              </button>
          </div>
          <div class='col-xs-2'>
          <p data-id='".$row[0]."'>Likes: " .$row[5]."</p>
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

    if(is_null($row[8])) {
      $img = "<div class='postContent'>
                <h2 class='postText'>".$postBody."</h2>
              </div>";
    } 
    else {
      $img = "<div class='postContentImage'>
                <img src='../Assets/imgs/posts/".$row[8]."' class='postImg'/><br>
                <h2 class='postText'>".$postBody."</h2>
              </div>";
    }

    if ($row[9] == $user_id) {
      $deleteButton = "<button class='delete btn btn-light' data-id='".$row[0]."'><i class='fas fa-trash-alt'></i></button>";
    } else {
      $deleteButton = "";
    }

      $date = date_format(new DateTime($row[1]),"d F Y G:i");
      if ($row[6] == 1) { $price = "<p style='color: green;'><i class='fas fa-hand-holding-usd'></i> £".$row[7]."</p>" ;} else {$price = "";}
      $posts .= "
      <div class='post' data-aos='fade-up'
      data-aos-duration='400'>
        <div class='container'>
          <div class='row'>
              <div class='col-xs-3'>
              <div style='background-image: url(Assets/imgs/users/".$row[4].") !important;' class='profilePhoto'></div>
              </div>
              <div class='col-xs-7 postDetails'>
                <b><a href='user_profile.php?username=$row[3]'>" .$row[3]."</a></b>
                <p><i class='far fa-clock'></i> ".$date."</p>".$price."
              </div>
              <div class='col-xs-2 ml-auto mr-3'>
              ".$deleteButton."
              </div>
            </div>
          <div class='row'>
          ".$img."
          </div>
            <hr>
            <div class='col-xs-10'>
              <button type='submit' class='btn btn-danger like' name='like' data-id='".$row[0]."'>
                  <i class='fas fa-heart'></i>
                </button>
            </div>
            <div class='col-xs-2'>
            <p data-id='".$row[0]."'>Likes: " .$row[5]."</p>
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
      <?php include($_SERVER['DOCUMENT_ROOT']."/head.php"); ?>
      <div class="main-wrapper">
         <div id="feedHeader" class="jumbotron jumbotron-fluid" >
            <div class="container">
               <h1 class="display-2">WELCOME, <?php echo strtoupper($forename); ?></h1>
               <p id="feedCaption">Keep up to date with all the posts from people you follow</p>
            </div>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-lg-3 order-2 order-lg-1" data-aos='fade-up'
    data-aos-duration='600'>
                  <div class="sidebar">
                     <div class="sidebarTitle">YOU FOLLOW</div>
                     <?php echo $friends ?>
                  </div>
               </div>
               <div class="col-lg-6 order-1 order-lg-2 postsColumnIndex">
                  <?php echo $posts; ?>
               </div>
               <div class="col-lg-3 order-3 order-lg-3" data-aos='fade-up'
    data-aos-duration='600'>
                  <div class="sidebar">
                     <div class="sidebarTitle">RECOMMENDATIONS</div>
                     <small>(Related Users)</small>
                     <?php echo $recomendations ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
      <?php include("footer.php"); ?>
   </body>
</html>

<script>
  $(document).ready(function(){



    $('.like').click(function() {
        var postid = $(this).attr('data-id');
        $.ajax({
         url:"like_post.php?post_id="+postid,
         success:function(data)
         {
          $('p[data-id="'+postid+'"]').text("Likes: " + data);

          if ($('.like[data-id="'+postid+'"]').hasClass('btn-danger')) {
            $('.like[data-id="'+postid+'"]').removeClass('btn-danger pulsate-fwd');
            $('.like[data-id="'+postid+'"]').addClass('btn-secondary'); 
          } else {
            $('.like[data-id="'+postid+'"]').removeClass('btn-secondary pulsate-fwd');
            $('.like[data-id="'+postid+'"]').addClass('btn-danger pulsate-fwd'); 
          }
         },
         error: function(data)
         {
          console.log("fail");
         }
      });
    });

    $('.delete').click(function() {
        var postid = $(this).attr('data-id');
        $.ajax({
         url:"delete_post.php?post_id="+postid,
         success:function(data)
         {
            console.log("deleted");
            location.reload();
         },
         error: function(data)
         {
          console.log("fail");
         }
      });
    });

  // $('#like').click(function like_post(query)
  // {
  // $.ajax({
  //  url:"like_post.php",
  //  success:function(data)
  //  {
  //   //$('#users').html(data);
  //  }
  // });

});


</script>