<?php 

session_start();
include ("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

$followerID = $_GET['follower_id'];
$type = $_GET['type'];

$output = "";

if ($type == "accept") {

	$sql = "DELETE FROM followers_requests WHERE user_id = '$user_id' AND follower_id = '$followerID'";
    $result = mysqli_query($db, $sql);

    $sql = "INSERT INTO followers (user_id, follower_id) VALUES ($user_id, $followerID)";
    $result = mysqli_query($db, $sql);

    $output .= "follow accepted";

} else if ($type == "reject") {
	$sql = "DELETE FROM followers_requests WHERE user_id = '$user_id' AND follower_id = '$followerID'";
    $result = mysqli_query($db, $sql);

    $output .= "follow rejected";

}

echo $output;

?>