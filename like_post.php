<?php 

session_start();
include ("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

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
}

$post_id = $_GET['post_id'];

$sql = "SELECT user_id FROM post_likes WHERE post_id= $post_id AND user_id = $user_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) < 1) {

	$sql = "UPDATE post SET likes = likes + 1 WHERE post = $post_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
  	$sql = "INSERT INTO post_likes (post_id, user_id) VALUES ($post_id, $user_id)";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	$last_row = mysqli_insert_id($db);
  	notify("", $last_row, 2, $db);

} else {

  	$sql = "UPDATE post SET likes = likes - 1 WHERE post = $post_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
  	$sql = "DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

}

$sql = "SELECT likes FROM post WHERE post = $post_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$row=mysqli_fetch_array($result);

echo $row[0];

?>