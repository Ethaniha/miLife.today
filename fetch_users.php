<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$searchOuput = "<div data-aos='fade-up'
    data-aos-duration='400' class='messageUsers'>";

  	$sql = "SELECT  users.forename, users.surname, users.image FROM users, followers WHERE users.user_id = followers.user_id AND followers.follower_id = '$user_id'";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	if(mysqli_num_rows($result) > 0) {

  		while ($row = mysqli_fetch_array($result)) {

				$searchOuput .= "<li class='list-group-item messageUser' id='user'>
				<div class='container'><div class='row'>
														<div class='col-xs-3'>
															<img src='../Assets/imgs/users/".$row[2]."' class='profilePhoto'/>
														</div>
														<div class='col-xs-9 messageUserDetails'>
															<strong>".ucwords($row[0])." ".ucwords($row[1])."</strong>
														</div>
														</div>
														</div>
													</li>";

  		}
  		$searchOuput .= "</div>";
	}
	echo $searchOuput;

?>


