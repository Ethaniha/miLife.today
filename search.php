<?php
	include ("db.php");

	$searchOuput = "";

	if(isset($_POST["query"])) {

		$search = $_POST['query'];
		$search = $db->real_escape_string($search);

	  	$sql = "SELECT username, image FROM users WHERE LOWER(username) LIKE LOWER('%$search%') ";
	  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

	  	if(mysqli_num_rows($result) > 0) {

	  		while ($row = mysqli_fetch_array($result)) {

				  $searchOuput .= "<li class='list-group-item messageUser'>
				  <a href='user_profile.php?username=".$row[0]."'><div class='container'><div class='row'>
														  <div class='col-xs-3'>
														  <div style='background-image: url(Assets/imgs/users/".$row[1].") !important;' class='profilePhoto'></div>
														  </div>
														  <div class='col-xs-9 messageUserDetails'>
															  <strong>".$row[0]."</strong>
														  </div>
														  </div>
														  </div>
														  </a>
													  </li>";
	  		}

	  	
		  }
		  
	  	$sql = "SELECT id, name, image FROM groups WHERE LOWER(name) LIKE LOWER('%$search%') ";
	  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
	  
			if(mysqli_num_rows($result) > 0) {
	  
				while ($row = mysqli_fetch_array($result)) {	  
					$searchOuput .= "<li class='list-group-item messageUser'>
					<a href='group_profile.php?group_id=".$row[0]."'><div class='container'><div class='row'>
															<div class='col-xs-3'>
															<div style='background-image: url(Assets/imgs/groups/".$row[2].") !important;' class='profilePhoto'></div>
															</div>
															<div class='col-xs-9 messageUserDetails'>
																<strong>".$row[1]."</strong>
															</div>
															</div>
															</div>
															</a>
														</li>";
				}
	  
				
		  }
		  echo $searchOuput;

	}



?>