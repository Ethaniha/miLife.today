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
}

$post_id = $_GET['post_id'];

$sql = "SELECT user_id FROM group_post_likes WHERE post_id = $post_id AND user_id = $user_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) < 1) {

	$sql = "UPDATE group_post SET likes = likes + 1 WHERE post = $post_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
  	$sql = "INSERT INTO group_post_likes (post_id, user_id) VALUES ($post_id, $user_id)";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	$last_row = mysqli_insert_id($db);
  	//notify("", $last_row, 2, $db);

} else {

  	$sql = "UPDATE group_post SET likes = likes - 1 WHERE post = $post_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
  	$sql = "DELETE FROM group_post_likes WHERE post_id = $post_id AND user_id = $user_id";
  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

}

$sql = "SELECT likes FROM group_post WHERE post = $post_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$row=mysqli_fetch_array($result);

echo $row[0];

?>