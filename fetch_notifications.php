<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$searchOuput = "";

  	$sql = "SELECT notifications.type, notifications.sender_id, notifications.post_id FROM notifications WHERE notifications.receiver_id = '$user_id' ";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	if(mysqli_num_rows($result) > 0) {

  		while ($row = mysqli_fetch_array($result)) {

  			$type = $row[0];

  			if ($type == 1) {

	  			$post_id = $row[2];

	  			$postsql = "SELECT post.body FROM post WHERE post.post = '$post_id'";
	  			$postresult = mysqli_query($db, $postsql);
	  			$postrow=mysqli_fetch_array($postresult);

	  			$sender_id = $row[1];

				$sql = "SELECT username FROM users WHERE user_id = '$sender_id' ";
				$result2 = mysqli_query($db, $sql);
				$row2=mysqli_fetch_array($result2);
				$sender_id = $row2[0];  			

	  			$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'><span style='font-size:16px;'><strong>".$sender_id."</strong> Mentioned you in a post: ".$postrow[0]." </span></li>";

  			}
  			else if ($type == 2) {

	  			$post_id = $row[2];

	  			$postsql = "SELECT post.body FROM post WHERE post.post = '$post_id'";
	  			$postresult = mysqli_query($db, $postsql);
	  			$postrow=mysqli_fetch_array($postresult);

	  			$sender_id = $row[1];

				$sql = "SELECT username FROM users WHERE user_id = '$sender_id' ";
				$result2 = mysqli_query($db, $sql);
				$row2=mysqli_fetch_array($result2);
				$sender_id = $row2[0];  			

	  			$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'><span style='font-size:16px;'><strong>".$sender_id."</strong> Liked your post </span></li>";

  			}
  			else if ($type == 3) {

  				$comment_id = $row[2];

	  			$postsql = "SELECT users_comments.body FROM users_comments WHERE users_comments.id = '$comment_id'";
	  			$postresult = mysqli_query($db, $postsql);
	  			$postrow=mysqli_fetch_array($postresult);

	  			$sender_id = $row[1];

				$sql = "SELECT username FROM users WHERE user_id = '$sender_id' ";
				$result2 = mysqli_query($db, $sql);
				$row2=mysqli_fetch_array($result2);
				$sender_id = $row2[0];  			

	  			$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'><span style='font-size:16px;'><strong>".$sender_id."</strong> Commented on your post: ".$postrow[0]." </span></li>";
  			}
  			else {
  				$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'><span style='font-size:16px;'><strong>You have no notifications</strong> </span></li>";
  			}

  		}

  		echo $searchOuput;

	}
?>


