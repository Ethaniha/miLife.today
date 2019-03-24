<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];
$messagerUsername = "";

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

?>

<html>
   
  <head>
    <title>miLIFE | Notifications</title>
      
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <?php include("head.php"); ?>
<div class="main-wrapper">
  <div class="container">

    <h1 class="pageHeader">My Notifications</h1></div>
      <div>
          <div class="container">
              <div class="row">
                    <div class="col-md-3">
                    <form type="post" action="">
                      <button type="button" class="btn btn-danger btn-sm" id="remove">Remove All</button></br>
                    </form>
                    </div>
                    <div class="col-md-12">
                      <ul class="list-group" id="users">
                      </ul>
                    </div>
          </div>
</div>

  </div>

</div>


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <?php include("footer.php"); ?>
  </body>
</html>


<script>
  $(document).ready(function(){

  load_data();

  //$("#users").on("click", "#remove", function() { 
     //$(this).parent().remove();
  //});


  function load_data(query)
  {
  $.ajax({
   url:"fetch_notifications.php",
   success:function(data)
   {
    $('#users').html(data);
   }
  });
  }

  //$("#remove").click(function(){
      //alert("button");
 //}); 





});
</script>
