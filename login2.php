<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Login - The Station Hotel</title>
  </head>

  <body>

    <?php 
    //starts session in file
    session_start();

    //variables set for database connection
    $host="localhost:3306";
    $username="root";
    $password="password";
    $db_name="socialmedia"; 
    $tbl_name="users";

    //creates array for errors
    $errorArray = array();
    //Creats array with field names
    $requiredArray = array('user','pass');
    //sets variables to be used
    $error = false;
    $pass = false;
    $success = false;

    //Checks that button has been submitted in form before running the PHP
    if(isset($_POST['login'])) {

        //Sets variables using the values of the Posted fields
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        /* Foreach loop runs through each
        field set in the 'requireArray',
        it checks that the posted field is
        not empty. */
        foreach($requiredArray as $field) {
  	        if (empty($_POST[$field])) {
                array_push($errorArray, "Please complete all fields.");
		        $error = True;
		        break;
  		    }
	    }

        //If the errorarray is empty there were no errors, uses this incase other ifs are added.
        if (count($errorArray) == 0 ) {
            $pass = True;
        }

        //Runs if there were no errors
        if ($pass == True) {

            //Attempts to connect to the database, if not it gives an error.
            mysql_connect("$host", "$username", "$password")or die("Unable to connect."); 
            mysql_select_db("$db_name")or die("cannot select DB");

            //Sets variables from the form
            $formusername = $_POST['user'];
            $formpassword = $_POST['pass'];

            //Strips Slashes from the variable to stop SQL injection
            $formusername = stripslashes($formusername);
            $formpassword = stripslashes($formpassword);
            //Escapes special characters to prevent SQL Injection
            $formusername = mysql_real_escape_string($formusername);
            $formpassword = mysql_real_escape_string($formpassword);
            //Uses MD5 to encrypt the password
            $formpassword=md5($formpassword);

            /* Selects row from the database in table Users where the username is the same as the one input into the form
            and that the password is the same as one on the same row */
            $sql="SELECT * FROM $tbl_name WHERE email='$formusername' and password='$formpassword'";
            //Querys the database using the statments stored in the 'sql' variable.
            $outcome=mysql_query($sql);
            //Counts how many rows output True with the statement
            $count=mysql_num_rows($outcome);
            //Fetches the values on the row in an array format.
            $data=mysql_fetch_array($outcome);

            //If a row was found it runs the code in the if statment
            if ($count==1) {
                //Sets variable to value of id column for row fetched, this defines the users ID for later use.
                $userid = $data['ID'];
                //Sets Variable to value of the admin column for the row fetched, this defines the user type.
                $usrtype = $data['admin'];

                //Sets session variables using local variables to be used in other files, remembers users details over the session.
                $_SESSION['usrtype'] = $usrtype;
                $_SESSION['user_id'] = $userid;
                $_SESSION['loggedin']= true;
                $_SESSION['username']= $formusername;
                //Redirects to the index page
                header("location:/index.php");
            } else {
                //If there was no rows the username of password must be incorrect so it pushes an error.
                array_push($errorArray, "Username or Password entered incorrectly.");  
            }

        }

    }


    ?>

    <!-- Attaches a style sheet -->
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <!-- Creates the background container -->
    <div class="background-overlay-login"></div>
    
    <!-- Defines login container to set layout for the login -->
    <div class="login-container">

        <!-- Creates a Form -->
	    <form id='login' method='post' accept-charset='UTF-8'>

            <!-- Creates a table so the form can be easily structured into rows for easier readability -->
            <table>

            <!-- Creates a row in table -->
            <tr>
                <!-- Creates a cell on the row currently open -->
                <td><label class="legend">User Login</label></td>
            </tr>
            <tr>
                <td><hr></td>
            </tr>
            <tr>
                <!-- Creates a label -->
	            <td><label for='username'>Username:</label></td>
            </tr>
            <tr>
                <!-- Creates a form input for the username -->
	            <td><input class="input-text" type='text' name='user' id='username'  maxlength="50" /></td>
            </tr>
            <tr>
	            <td><label for='password' >Password:</label></td>
            </tr>
            <tr>
                <!-- Creates a form field for a password as the password type so it hides the text input -->
	            <td><input type='password' name='pass' id='password' maxlength="50" /></tD>
            </tr>
            <tr>   
                <!-- Creates a checkbox to remember password -->
 	            <td><label><input type="checkbox"> Remember me</label></td>
            </tr>
            <tr>
                <!-- Creates a submit button to submit the form -->
	            <td><input class="button" type='submit' name='login' value='Login' /></td>
            </tr>
            <tr>
                <!-- Creates a button to redirect to the register page -->
                <td><label>Not a user?<a href="register.php"> Register Here! </a></label>
            </tr>
            <tr>
                <td><hr></td>
            </tr>
            <tr>
                <!-- Creates a container for the error to be echoed in if any -->
                <td><div class="error"><?php 
                    // If the array isn't empty it will echo each error stored in it
                    if (count($errorArray) > 0) {
	                    foreach ($errorArray as &$error) {
    		                echo "$error";
			                echo "<br>";
	                    }
	
	                } 
                    ?></div></td>
            </tr>
            </table>
 
	    </form>
	</div>



</body>
</html>
