<?php
	include ("db.php");

	$searchOuput = "";

	if(isset($_POST["query"])) {

		$search = $_POST['query'];

	  	$sql = "SELECT username FROM users WHERE username LIKE '%$search%' ";
	  	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

	  	if(mysqli_num_rows($result) > 0) {

	  		while ($row = mysqli_fetch_array($result)) {

	  			$searchOuput .= "<li class='list-group-item' style='position:relative;width:50%; z-index:102'><span>".$row[0]."</span></li>";

	  		}

	  		echo $searchOuput;

	  	}
	}



?>