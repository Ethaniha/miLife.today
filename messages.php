<?php 
session_start();

include("db.php");

$myusername = $_SESSION['login_user'];
$messagerUsername = "";

$sql = "SELECT User_ID FROM users WHERE email = '$myusername' ";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result);
$user_id = $row[0];

if(isset($_GET['username'])) {

  $messagerUsername = $_GET['username'];

  if(isset($_POST['sendmessage'])) {

    $sql = "SELECT User_ID FROM users WHERE username = '$messagerUsername' ";
    $result = mysqli_query($db, $sql);
    $row=mysqli_fetch_array($result);
    $messagerUserId = $row[0];

    $messageBody = $_POST['messagebody'];

    if(!empty($messageBody)) {
      
        $sql = "INSERT INTO messages (body, sender_id, receiver_id, read_status) VALUES ('$messageBody', '$user_id', '$messagerUserId', 0)";
        $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    }
    else {
      echo "empty";
    }

    $sql = "";
  }

}

?>

<html>
   
  <head>
    <title>miLIFE | Messages</title>
      
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <?php include("head.php"); ?>

  <div class="container">

    <h1>My Messages</h1></div>
      <div>
          <div class="container">
              <div class="row">
                  <div class="col-md-3">
                      <ul class="list-group" id="users">
                      </ul>
                  </div>
                  <div class="col-md-9" style="position:relative;">
                      <ul class="list-group" id="chatbox">
                          <li class="list-group-item" id="messages" style="overflow:auto;height:500px;margin-bottom:55px;">
                          </li>
                      </ul>
                      <form action='' method="post">
                        <div class="input-group mb-3">
                          <input type="text" class="form-control" placeholder="Type your message here.." name="messagebody">
                          <div class="input-group-append">
                            <button class="btn btn-success" type="submit" name="sendmessage">Send</button>
                          </div>
                        </div>
                      </form>
              </div>
          </div>
</div>

  </div>




  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

  </body>
</html>


<script>
  $(document).ready(function(){

  load_data();
  var username = "<?php echo $messagerUsername; ?>";
  load_messages();

  function load_data(query)
  {
  $.ajax({
   url:"fetch_users.php",
   success:function(data)
   {
    $('#users').html(data);
   }
  });
  }

  function load_messages(query)
  {
  $.ajax({
   url:"fetch_messages.php?username="+username,
   success:function(data)
   {
    $('#messages').html(data);
    var objDiv = document.getElementById("messages");
    objDiv.scrollTop = objDiv.scrollHeight;
   },
   error: function(data)
   {
    console.log("fail");
   }
  });
  }

  window.setInterval(function(){
    load_messages();
  }, 5000);


  $('#users').on('click', 'li', function() {
  var contents = $(this).text();
  var url="messages.php?username=" + contents;
  window.location = url;
  });

  });
</script>
