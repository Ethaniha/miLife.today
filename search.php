<?php
	include ("db.php");

	$searchOuput = "";

	if(isset($_POST["query"])) {

		$search = $_POST['query'];

	  	$sql = "SELECT username, image FROM users WHERE username LIKE '%$search%' ";
	  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

	  	if(mysqli_num_rows($result) > 0) {

	  		while ($row = mysqli_fetch_array($result)) {

	  			$searchOuput .= "<li class='list-group-item'><span><a href='user_profile.php?username=".$row[0]."'><img class='searchimg profilePhoto' src='../Assets/imgs/users/".$row[1]."' width=50 height=50/>".$row[0]."</a></span></li>";

	  		}

	  	
		  }
		  
	  	$sql = "SELECT id, name, image FROM groups WHERE name LIKE '%$search%' ";
	  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));
	  
			if(mysqli_num_rows($result) > 0) {
	  
				while ($row = mysqli_fetch_array($result)) {
	  
					$searchOuput .= "<li class='list-group-item'><span><a href='group_profile.php?group_id=".$row[0]."'><img class='searchimg profilePhoto' src='../Assets/imgs/groups/".$row[2]."' width=50 height=50/>".$row[1]."</a></span></li>";
	  
				}
	  
				
		  }
		  echo $searchOuput;

	}



?>