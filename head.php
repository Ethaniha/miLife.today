    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      
  </head>
   
  <body bgcolor = "#FFFFFF">
    
  <nav class="navbar navbar-expand-sm bg-light navbar-light">

    <a class="navbar-brand" href="#">
      <img src="logo.png" alt="Logo">
    </a>

    <form class="form-inline mx-auto  my-auto" action="/action_page.php">
            <div class="input-group">
                <input class="form-control py-2 border-right-0 border" type="Search for something.." value="search" id="example-search-input">
                <span class="input-group-append">
                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                </span>
            </div>
    </form>


    <ul class="navbar-nav">
      <li class="nav-item">
        <i class="fas fa-bell fa-2x" data-count="2" style="color:grey"></i>
      </li>
      <li class="nav-item">
        <i class="fas fa-cogs fa-2x" style="color:grey"></i>
      </li>
      <li class="nav-item">

        <?php if(isset($_SESSION['login_user'])) {
          echo '<a href="user.php"><i class="fas fa-user fa-2x" style="color:grey"></i></a>';
        } else {
          echo '<a href="login.php"><i class="fas fa-user fa-2x" style="color:grey"></i></a>';
        } ?>  
      </li>
    </ul>
  </nav>


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>