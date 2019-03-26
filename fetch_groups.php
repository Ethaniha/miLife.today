<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$searchOuput = "";
 

  	$sql = "SELECT groups.name, groups.description, groups.image, groups.owner FROM groups, group_users WHERE groups.id = group_users.group_id AND group_users.user_id = '$user_id'";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	if(mysqli_num_rows($result) > 0) {

  		while ($row = mysqli_fetch_array($result)) {

  			$searchOuput .= "<li class='list-group-item' id='user' style='background-color:#f1eeee;'>
  								<div class='col-xs-3'>
              						<img src='../Assets/imgs/groups/".$row[2]."' class='profilePhoto' width=50 height=50/>
              						<span style='font-size:16px;'><strong>".$row[0]."</strong></span>
              						 - 
              						<span style='font-size:16px;'>".$row[1]."</span>
            					</div>
  							</li>";

  		}

  		echo $searchOuput;

	}
?>


