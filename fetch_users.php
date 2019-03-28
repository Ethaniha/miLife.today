<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$searchOuput = "<div data-aos='fade-right'
    data-aos-duration='400'>";

  	$sql = "SELECT users.username FROM users, followers WHERE users.user_id = followers.user_id AND followers.follower_id = '$user_id'";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	if(mysqli_num_rows($result) > 0) {

  		while ($row = mysqli_fetch_array($result)) {

  			$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'><span style='font-size:16px;'><strong>".$row[0]."</strong></span></li>";

  		}
  		$searchOuput .= "</div>";
	}
	echo $searchOuput;

?>


