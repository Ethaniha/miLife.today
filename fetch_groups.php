<?php
	session_start();
	include ("db.php");
	$myusername = $_SESSION['login_user'];

	$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
	$result = mysqli_query($db, $sql);
	$row=mysqli_fetch_array($result);
	$user_id = $row[0];

	$searchOuput = "<div class='row'data-aos='fade-up'
	data-aos-duration='400'> ";
 

  	$sql = "SELECT groups.name, groups.description, groups.image, groups.owner, groups.id FROM groups, group_users WHERE groups.id = group_users.group_id AND group_users.user_id = '$user_id'";
	$result = mysqli_query($db, $sql) or die(mysqli_error($db));

  	if(mysqli_num_rows($result) > 0) {

  		while ($row = mysqli_fetch_array($result)) {

			  $searchOuput .= "<div class='col-md-4'>
			  <a href='group_profile.php?group_id=".$row[4]."'><div class='card groupCard' >
									<div style='background-image: url(Assets/imgs/groups/".$row[2].") !important;' class='profilePhoto card-img-top'></div>
									<div class='card-body'>
									  	
              							<h5 class='card-title'>".$row[0]."</h5>
										<p class='card-text'>".$row[1]."</p>
            						</div></a>
  								</div></div>";

  		}

		  $searchOuput .= "</div>";
  		echo $searchOuput;

	}
?>

<!-- <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-primary">Go somewhere</a> -->
