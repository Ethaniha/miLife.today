<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	if(isset($_POST['message'])) {

		$messagerUsername = $_POST['username'];
		$messageBody = $_POST['message'];

	    $sql = "SELECT User_ID FROM users WHERE username = '$messagerUsername' ";
	    $result = mysqli_query($db, $sql);
	    $row=mysqli_fetch_array($result);
	    $messagerUserId = $row[0];

	    if(!empty($messageBody)) {
	      
	        $sql = "INSERT INTO messages (body, sender_id, receiver_id, read_status) VALUES ('$messageBody', '$user_id', '$messagerUserId', 0)";
	        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
	    }
	    else {
	      	echo "empty";
	    }

  }

	$body = $_POST['message']; // Don't forget the encoding
  	$data['message'] = $body;

  	echo json_encode($data);
?>