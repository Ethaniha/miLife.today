<?php 
session_start();
include ("db.php");

// function notify($body, $id, $type, $db) {

//   if ($type == 2) {
//     $sql = "SELECT post.user_id FROM post, post_likes WHERE post.post = post_likes.post_id";
//     $result = mysqli_query($db, $sql);
//     $row=mysqli_fetch_array($result);
//     $receiverID = $row[0];

//     $myusername = $_SESSION['login_user'];
//     $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
//     $result = mysqli_query($db, $sql);
//     $row=mysqli_fetch_array($result);
//     $user_id = $row[0];

//     $sql = "INSERT INTO notifications (type, sender_id, receiver_id, post_id) VALUES (2, '$user_id', '$receiverID', '$id')";
//     $result = mysqli_query($db, $sql) or die(mysqli_error($db));
//   }
//   else if ($type == 3) {
//     $sql = "SELECT user_id FROM users_comments WHERE id = '$id' ";
//     $result = mysqli_query($db, $sql);
//     $row=mysqli_fetch_array($result);
//     $receiverID = $row[0];

//     $myusername = $_SESSION['login_user'];
//     $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
//     $result = mysqli_query($db, $sql);
//     $row=mysqli_fetch_array($result);
//     $user_id = $row[0];

//     $sql = "INSERT INTO notifications (type, sender_id, receiver_id, post_id) VALUES (3, '$user_id', '$receiverID', '$id')";
//     $result = mysqli_query($db, $sql) or die(mysqli_error($db));
//   }


// }

<<<<<<< HEAD
// function addMention($post) {
// $body = explode(" ", $post);
// $newBody = "";

// foreach ($body as $word) {
//   if (substr($word,0,1) == "@")
//   {
//     $link = str_replace("@","",$word);
//     $newBody .= "<a href='user_profile.php?username=".$link."'>".$word." </a>";
//   } 
//   else 
//   {
//     $newBody .= $word." ";
//   }
// }

// return $newBody;
// }
=======
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
>>>>>>> test

$myusername = $_SESSION['login_user'];

$sql = "SELECT username FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$current_username = $row[0];

/////////////////

  $sql = "SELECT User_ID FROM users WHERE username = '$current_username' ";
  $result = mysqli_query($db, $sql);
  $row=mysqli_fetch_array($result);
  $user_id = $row[0];

  $sql = "SELECT id FROM followers WHERE user_id = '$user_id' ";
  $result = mysqli_query($db, $sql);
  $followers = mysqli_num_rows($result);

/////////////////

<<<<<<< HEAD
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
=======
if (isset($_GET['group_id'])) {
  $group_id = $_GET['group_id'];

  $sql = "SELECT name, description, owner,image FROM groups WHERE id = $group_id";
  $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  $row=mysqli_fetch_array($result);

  $groupName = $row[0];
  $groupDesc = $row[1];
  $groupOwner = $row[2];
  $groupImage = $row[3];

  $sql = "SELECT * FROM group_users WHERE group_id = $group_id";
  $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  $groupMembers = mysqli_num_rows($result);

  $sql = "SELECT users.image, users.forename, users.username  FROM users, group_users WHERE users.user_id = group_users.user_id AND group_users.group_id = $group_id AND $user_id != group_users.user_id";
  $result = mysqli_query($db, $sql) or die(mysqli_error($db));
  $members = "";

  while ($row = mysqli_fetch_array($result)) {
    $members .= '<div class="friend">
                  <div class="container">
                    <div class="row">
                    <div class="col-xs-3">
                    <img src="../Assets/imgs/users/'.$row[0].'" class="profilePhoto"/>
                    </div>
                    <div class="col-xs-9 postDetails">
                    <b><a href="user_profile.php?username='.$row[2].'">'.$row[1].'</a></b>
                    <p>@'.$row[2].'</p>
                    </div>
                    </div>
                  </div>
                </div>';
  }

  if(isset($_POST['sendgrouppost'])) {

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
  
        $sql = "INSERT INTO group_post (group_id body, posted_at, user_id, likes, image) VALUES ('$group_id','$postbody', '$time', '$user_id', 0, '$file_name')";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));

        $last_row = mysqli_insert_id($db);

        //notify($postbody);
  
      }
  
    } else if (!empty($errors)) {
      print_r($errors);
    }
    else {
      $postbody = $_POST['postbody'];
      $time = date("Y-m-d H:i:s");
  
      $sql = "INSERT INTO group_post (group_id, body, posted_at, user_id, likes) VALUES ('$group_id','$postbody', '$time', '$user_id', 0)";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));

      $last_row = mysqli_insert_id($db);
      //notifyPost($postbody, $last_row, 1, $db);

    }
  
  }

  if (isset($_GET['postid'])) {
    $postid = $_GET['postid'];

    if (isset($_POST['comment'])) {

      $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
      $result = mysqli_query($db, $sql);
      $row=mysqli_fetch_array($result);
      $commenter_id = $row[0];

      $commentbody = $_POST['commentbody'];
      $time = date("Y-m-d H:i:s");
      $sql = "INSERT INTO groups_comments (body, user_id, posted_at, post_id) VALUES ('$commentbody', '$commenter_id', '$time', '$postid' )";
      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    }

>>>>>>> test
  }

}

<<<<<<< HEAD
// $sql = "SELECT users.image, users.forename, users.username  FROM users, followers WHERE users.user_id = followers.user_id AND followers.follower_id = '$user_id' AND followers.follower_id != followers.user_id";
// $result = mysqli_query($db, $sql) or die(mysqli_error($db));
// $members = "";

// while ($row = mysqli_fetch_array($result)) {
//   $members .= '<div class="friend">
//                 <div class="container">
//                   <div class="row">
//                   <div class="col-xs-3">
//                   <img src="../Assets/imgs/users/'.$row[0].'" class="profilePhoto"/>
//                   </div>
//                   <div class="col-xs-9 postDetails">
//                   <b><a href="user_profile.php?username='.$row[2].'">'.$row[1].'</a></b>
//                   <p>@'.$row[2].'</p>
//                   </div>
//                   </div>
//                 </div>
//               </div>';
// }

// $sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes, post.image FROM users, post WHERE users.user_id = post.user_id AND post.user_id = $user_id ORDER BY `post`.`posted_at` DESC";
// $result = mysqli_query($db, $sql) or die(mysqli_error($db));
// $posts = "";

// while ($row = mysqli_fetch_array($result)) {
//   $postid = $row[0];
//   $comments = "";
//   $sql = "SELECT post_id FROM post_likes WHERE post_id=$postid and user_id=$user_id";
//   $result2 = mysqli_query($db, $sql) or die(mysqli_error($db));

//   $commentsql = "SELECT users_comments.body, users.username, users.image FROM users_comments, users WHERE post_id = $postid AND users_comments.user_id = users.User_ID";
//   $commentresult = mysqli_query($db, $commentsql) or die(mysqli_error($db));

//   $postBody = addMention($row[2]);
  
//   while ($commentrow = mysqli_fetch_array($commentresult)) {
//     $commentBody = addMention($commentrow[0]);
//     $comments .= "<div class='row comment'><div class='col-xs-2'><img src='../Assets/imgs/users/".$commentrow[2]."'class='profilePhoto'/></div><div class='col-xs-10 postCommentDetail'><b>".$commentrow[1]."</b><br>".$commentBody."</br></div></div>";
//   }

//   if (mysqli_num_rows($result2) < 1) {

//     if(is_null($row[6])) {
//       $img = "";
//     } 
//     else {
//       $img = "<br><img src='/Assets/imgs/posts/".$row[6]."' height=400/><br>";
//     }

//     $posts .= "
//     <div class='post' id='profilePost'>
//       <div class='container'>
//         <div class='row'>
//             <div class='col-xs-3'>
//               <img src='../Assets/imgs/users/".$row[4]."' class='profilePhoto'/>
//             </div>
//             <div class='col-xs-9 postDetails'>
//               <b><a href='user_profile.php?username=$row[3]'>" .$row[3]."</a></b>
//               <p><i class='far fa-clock'></i> ".$row[1]."</p>
//             </div>
//           </div>
//         <div class='row'>
//           <div class='postContent'>".$img."
//           <h2 class='postText'>".$postBody."</h2>
//           </div>
//         </div>
//           <hr>
//           <div class='col-xs-10'>
//             <form action='index.php?&postid=".$row[0]."' method='post'>
//             <button type='submit' class='btn btn-secondary' name='like'>
//                 <i class='fas fa-heart'></i>
//               </button>
//               </form>
//           </div>
//           <div class='col-xs-2'>
//           <p>Likes: " .$row[5]."</p>
//         </div>
//         <form action='index.php?postid=".$row[0]."' method='post'>
//         <div class='input-group mb-3'><input type='text' class='form-control' placeholder='Write a comment...' name='commentbody' rows='3' cols='40'></textarea>
//         <div class='input-group-append'><button type='submit' name='comment' value='Comment!' class='btn btn-secondary'>Post</button>
//         </div>
//         </div>
//       </form>
//       <div class='postComments'>".$comments."</div>
//       </div>
//     </div></br>";
//   } else {

//     if(is_null($row[6])) {
//       $img = "";
//     } 
//     else {
//       $img = "<br><img src='/Assets/imgs/posts/".$row[6]."' height=400/><br>";
//     }
//     $posts .= "
//     <div class='post' id='profilePost'>
//       <div class='container'>
//         <div class='row'>
//             <div class='col-xs-3'>
//               <img src='../Assets/imgs/users/".$row[4]."' class='profilePhoto'/>
//             </div>
//             <div class='col-xs-9 postDetails'>
//               <b><a href='user_profile.php?username=$row[3]'>" .$row[3]."</a></b>
//               <p><i class='far fa-clock'></i> ".$row[1]."</p>
//             </div>
//           </div>
//         <div class='row'>
//           <div class='postContent'>".$img."
//           <h2 class='postText'>".$postBody."</h2>
//           </div>
//         </div>
//           <hr>
//           <div class='col-xs-10'>
//             <form action='index.php?&postid=".$row[0]."' method='post'>
//             <button type='submit' class='btn btn-danger' name='like'>
//                 <i class='fas fa-heart'></i>
//               </button>
//               </form>
//           </div>
//           <div class='col-xs-2'>
//           <p>Likes: " .$row[5]."</p>
//         </div>
//         <form action='index.php?postid=".$row[0]."' method='post'>
//         <div class='input-group mb-3'><input type='text' class='form-control' placeholder='Write a comment...' name='commentbody' rows='3' cols='40'></textarea>
//         <div class='input-group-append'><button type='submit' name='comment' value='Comment!' class='btn btn-secondary'>Post</button>
//         </div>
//         </div>
//       </form>
//       <div class='postComments'>".$comments."</div>
//       </div>
//     </div></br>";
//   }
// }
=======

$sql = "SELECT group_post.post, group_post.posted_at, group_post.body, users.username, users.image, group_post.likes, group_post.image FROM users, group_post, groups WHERE groups.id = group_post.group_id AND users.user_id = group_post.user_id  ORDER BY `group_post`.`posted_at` DESC";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$posts = "";

// $sql = "SELECT post.post, post.posted_at, post.body, users.username, users.image, post.likes FROM users, post, followers WHERE post.user_id = followers.user_id AND users.user_id = post.user_id AND follower_id = '$user_id' ORDER BY `post`.`posted_at` DESC";
// $result = mysqli_query($db, $sql) or die(mysqli_error($db));
// $posts = "";

while ($row = mysqli_fetch_array($result)) {
  $postid = $row[0];
  $comments = "";
  $sql = "SELECT post_id FROM group_post_likes WHERE group_id = $group_id AND post_id=$postid and user_id=$user_id";
  $result2 = mysqli_query($db, $sql) or die(mysqli_error($db));

  $commentsql = "SELECT groups_comments.body, users.username, users.image FROM groups_comments, users WHERE post_id = $postid AND groups_comments.user_id = users.User_ID";
  $commentresult = mysqli_query($db, $commentsql) or die(mysqli_error($db));

  $postBody = addMention($row[2]);
  
  while ($commentrow = mysqli_fetch_array($commentresult)) {
    $commentBody = addMention($commentrow[0]);
    $comments .= "<div class='row comment'><div class='col-xs-2'><img src='../Assets/imgs/users/".$commentrow[2]."'class='profilePhoto'/></div><div class='col-xs-10 postCommentDetail'><b>".$commentrow[1]."</b><br>".$commentBody."</br></div></div>";
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
            <button type='submit' class='btn btn-danger like' name='like' data-id='".$row[0]."''>
                <i class='fas fa-heart'></i>
            </button>
          </div>
          <div class='col-xs-2'>
          <p data-id='".$row[0]."'>Likes: " .$row[5]."</p>
        </div>
        <form action='group_profile.php?group_id=".$group_id."&postid=".$row[0]."' method='post'>
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
            <button type='submit' class='btn btn-secondary like' name='like' data-id='".$row[0]."''>
                <i class='fas fa-heart'></i>
            </button>
          </div>
          <div class='col-xs-2'>
          <p data-id='".$row[0]."'>Likes: " .$row[5]."</p>
        </div>
        <form action='group_profile.php?group_id=".$group_id."&postid=".$row[0]."' method='post'>
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
>>>>>>> test

?>

<html>
   
  <head>

    <title>miLIFE | <?php echo $groupName ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
  </head>
   
  <body bgcolor = "#FFFFFF">
      
    <?php include("head.php"); ?>
    <div class="main-wrapper">

    <div class="container">
    <div class="row">
<div class="col-md-3">
<<<<<<< HEAD
<?php echo "<img src='/Assets/imgs/users/".$avatar."' id='profilePagePhoto'/>"; ?>
</div>
<div class="col-md-4">
<h2 id="profileHeader"> Group Name Here
<!-- <?php echo $groupName;?> -->
</h2>

<b>Description: </b>Example Description<br>

<b>Members: </b>67<br>
<?php 

  $sql = "SELECT User_ID FROM users WHERE username = '$username' ";
  $result = mysqli_query($db, $sql);
  $row=mysqli_fetch_array($result);
  $user_id = $row[0];

  $sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
  $result = mysqli_query($db, $sql);
  $row=mysqli_fetch_array($result);
  $follower_id = $row[0];

  $sql = "SELECT id FROM followers WHERE user_id = '$user_id' AND follower_id = '$follower_id' ";
=======
<?php echo "<img src='../Assets/imgs/groups/".$groupImage."' id='profilePagePhoto'/>"; ?>
</div>
<div class="col-md-4">
<h2 id="profileHeader"> 
<?php echo $groupName;?>
</h2>

<b>Description: </b><?php echo $groupDesc; ?> <br>

<b>Members: </b><?php echo $groupMembers; ?><br>
<?php 

  $sql = "SELECT id FROM group_users WHERE group_id = $group_id AND user_id = $group_id ";
>>>>>>> test
  $result = mysqli_query($db, $sql);

  if (mysqli_num_rows($result) == 1) {
    echo '<form action="" method="post" >
      <input type="submit" name="follow" value="Leave Group" class="btn btn-primary" id="followButton">
</form>';
  }
  else {
    echo '<form action="" method="post" >
      <input type="submit" name="follow" value="Join Group" class="btn btn-primary" id="followButton">
</form>';

    //echo "user followed";
}

?>
</div>
</div>
<div class="row profileBody">
<div class="col-lg-3 order-2 order-lg-1">
<h5 class="sectionHeader">Members</h5>
<br>
      <div class="sidebar">
      <?php echo $members ?>
      </div>
    </div>
    <div class="col-lg-9 order-1 order-lg-2">
<<<<<<< HEAD
=======
    <div>
      <form action="" method="post" enctype="multipart/form-data">
        <textarea  class="form-control" name="postbody" rows="5" cols="80"></textarea>
        <br>
        <input type = "file" name = "image" class="btn btn-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="sendgrouppost" value="Post!" class="btn btn-primary">
      </form>
    </div>
>>>>>>> test
    <h5 class="sectionHeader">Posts</h5>
<p>(in chronological order)</p>
    <?php echo $posts; ?>
</div>
</div>
  </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <?php include("footer.php"); ?>
  </body>
</html>

<<<<<<< HEAD
=======
<script>
  $(document).ready(function(){

    $('.like').click(function() {
        var postid = $(this).attr('data-id');
        $.ajax({
         url:"like_group_post.php?post_id="+postid,
         success:function(data)
         {
          $('p[data-id="'+postid+'"]').text("Likes: " + data);

          if ($('.like[data-id="'+postid+'"]').hasClass('btn-danger')) {
            $('.like[data-id="'+postid+'"]').removeClass('btn-danger');
            $('.like[data-id="'+postid+'"]').addClass('btn-secondary'); 
          } else {
            $('.like[data-id="'+postid+'"]').removeClass('btn-secondary');
            $('.like[data-id="'+postid+'"]').addClass('btn-danger'); 
          }
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

>>>>>>> test



