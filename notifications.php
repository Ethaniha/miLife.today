<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];
$messagerUsername = "";

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

if (isset($_POST['remove'])) {
  $sqlremove = "DELETE FROM notifications WHERE receiver_id = $user_id ";
  $result = mysqli_query($db, $sqlremove) or die(mysqli_error($db));
}


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
  <div id="notificationHeader" class="jumbotron jumbotron-fluid" >
    <div class="container">
      <h1 class="notificationH1">My Notifications</h1>
      
    </div>
  </div>
  <div class="container">
    <div>
      <div class="container">
        <div class="row">
          <div class="col-md-6 text-left">
            <form method="post" action="">
              <button type="submit" class="btn btn-danger" id="remove" name="remove">Remove All</button></br>
            </form>
          </div>
          <div class="col-md-6 text-right">
            <?php
            $sql = "SELECT privacy FROM users_settings WHERE user_id = $user_id";
            $result = mysqli_query($db, $sql) or die(mysqli_error($db));
            $row = mysqli_fetch_array($result);
            $privacySetting = $row[0];

            if ($privacySetting == 1 ) {
              $sql = "SELECT id FROM  followers_requests WHERE user_id = '$user_id' ";
              $result = mysqli_query($db, $sql);
              $numOfFollows = mysqli_num_rows($result);

              echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#followersModal'>".$numOfFollows." Follow Requests </button>";
            }

            ?>
          </div>

            <div class="modal face" id="followersModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                  <h3>Follower Requests</h3>
                  </div>
                  <div class="modal-body">
                    <?php
                    if ($numOfFollows > 0) {
                      $sql = "SELECT follower_id FROM  followers_requests WHERE user_id = '$user_id' "; 
                      $result = mysqli_query($db, $sql) or die(mysqli_error($db));
                      while ($row = mysqli_fetch_array($result)) {

                        $followerID = $row[0];
                        $sql2 = "SELECT username FROM users WHERE User_ID = '$followerID' ";
                        $result2 = mysqli_query($db, $sql2);
                        $row2=mysqli_fetch_array($result2);
                        $follower_username = $row2[0];

                        echo "<div class='alert' id='user' data-id='".$followerID."'><strong>".$follower_username."</strong> Requested to follow you:    
                          <button type='submit' class='btn btn-success followReqAccept' name='acceptFollow' data-id='".$followerID."'><i class='fas fa-check'></i></button>
                          <button type='submit' class='btn btn-danger followReqDecline' name='declineFollow' data-id='".$followerID."'><i class='fas fa-times'></i></button>
                          </div>";
                      }
                    }
                    ?>
                  </div>
                  <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12" data-aos='fade-up'
    data-aos-duration='400'>
            <ul class="list-group" id="users">
            </ul>
          </div>
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
  $('.followReqAccept').click(function() {
      var followerid = $(this).attr('data-id');

      var type = "accept";

      $.ajax({
       url:"follow_requests.php?follower_id="+followerid+"&type="+type,
       success:function(data)
       {
        console.log(data);
        $('div[data-id="'+followerid+'"]').text("Follow Accepted");
       },
       error: function(data)
       {
        console.log("fail");
       }
    });
  });

    $('.followReqDecline').click(function() {
      var followerid = $(this).attr('data-id');

      var type = "reject";

      $.ajax({
       url:"follow_requests.php?follower_id="+followerid+"&type="+type,
       success:function(data)
       {
        console.log(data);
        $('div[data-id="'+followerid+'"]').text("Follow Rejected");
       },
       error: function(data)
       {
        console.log("fail");
       }
    });
  });

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
