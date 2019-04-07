<?php

include("db.php");


$sql = "SELECT username, Password FROM users";
$result=mysqli_query($db,$sql) or die(mysqli_error($db));

while ($row = mysqli_fetch_array($result)) {
    $newHash = password_hash($row[1], PASSWORD_DEFAULT);
    $username = $row[0];
    $sql = "UPDATE users SET password = '$newHash' WHERE username = '$username'";
    $resultPass=mysqli_query($db,$sql) or die(mysqli_error($db));
}

?>