<?php 

session_start();
include ("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];
$post_id = $_GET['post_id'];

$sql = "DELETE FROM post WHERE post= $post_id AND user_id = $user_id";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
echo "<meta http-equiv='refresh' content='0'>";
?>