
<?php 

session_start();
include ("db.php");
$myusername = $_SESSION['login_user'];

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

$memberID = $_GET['memberID'];
$groupID = $_GET['groupID'];

$sql = "SELECT owner FROM groups WHERE id = $groupID";
$result = mysqli_query($db, $sql) or die(mysqli_error($db));
$row=mysqli_fetch_array($result);

$ownerID = $row[0];

$output = "";

if ($ownerID == $user_id) {
	$sql = "DELETE FROM group_users WHERE group_id = $groupID AND user_id = $memberID";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

}

?>