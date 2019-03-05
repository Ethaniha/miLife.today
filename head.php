    <link rel="stylesheet" href="css/main.css">

  <nav class="navbar navbar-expand-sm bg-light navbar-light">

    <div class="container">
   <a href="index.php" ><img src="assets/logo.png" alt="Logo" class="navbar-logo"></a>

<?php if(isset($_SESSION['login_user'])) {
    echo'<form class="form-inline mx-auto  my-auto" action="/action_page.php">
            <div class="input-group">
                <input class="form-control py-2 border-right-0 border" type="Search for something.." placeholder="Search for something.." id="example-search-input">
                <span class="input-group-append">
                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                </span>
            </div>
    </form>'; } ?>


    <ul class="navbar-nav">
<?php if(isset($_SESSION['login_user'])) {
      echo '<li class="nav-item">
        <i class="fas fa-bell fa-2x" data-count="2" style="color:grey"></i>
      </li>
      <li class="nav-item">
        <a href="user_settings.php"><i class="fas fa-cogs fa-2x" style="color:grey"></i></a>
      </li>';
    } ?>
      <li class="nav-item">

        <?php if(isset($_SESSION['login_user'])) {
          echo '<a href="user_profile.php?username='.$_SESSION['username'].'"><i class="fas fa-user fa-2x" style="color:grey"></i></a>';
        } else {
          echo '<a href="login.php"><i class="fas fa-user fa-2x" style="color:grey"></i></a>';
        } ?>  
      </li>
    </ul>
    </div>
  </nav>
