<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$messagerUsername = $_GET['username'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$sql = "SELECT User_ID FROM users WHERE username = '$messagerUsername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$messagerUserId = $row[0];



	$messages = "";

	$sql = "SELECT body, sender_id FROM messages WHERE sender_id = '$user_id' AND receiver_id = '$messagerUserId' OR sender_id = '$messagerUserId' AND receiver_id = '$user_id' ";
	$result = mysqli_query($db, $sql);

	if(mysqli_num_rows($result) > 0) {

		while ($row=mysqli_fetch_array($result)) {
			if ($row[1] == $user_id) {
				$messages .= "<div class='message-from-me'>".$row[0]."</div><br>";
			}
			else {
				$messages .= "<div class='message-from-other'>".$row[0]."</div><br>";
			}
		}

		echo $messages;
	}



?>
