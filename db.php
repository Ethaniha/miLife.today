<?php 

define('DB_SERVER', 'shareddb-m.hosting.stackcp.net');
define('DB_USERNAME', 'project-3130313b73');
define('DB_PASSWORD', 's7vwjao7mf');
define('DB_DATABASE', 'project-3130313b73');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

?>