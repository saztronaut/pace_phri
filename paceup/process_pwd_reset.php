<?php

require 'database.php';
require 'sessions.php';

if ($_POST){
    
	$password=htmlspecialchars($_POST['password'], ENT_QUOTES);
	$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
	// check to see if is email
	$email_ = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	//get username from email
	$getUser = "SELECT username from users WHERE LOWER(email) = LOWER('" . $email . "');";
	$result= mysqli_query($connection, $getUser) or die('Error checking token'. mysql_error());
	$row = mysqli_fetch_array($result);
	if ($result->num_rows==0){
		echo "<p>Sorry, that password reset must have timed out. <a href='./main_index.php'>Please request another token</a></p>";
	}
	//the username from the token was stored in the session
	else if ($row['username']==$_SESSION['get_username']){
		//This means the user token is for the same user as the email address
		//new salt for a new password
		$salt = bin2hex(openssl_random_pseudo_bytes(6));
		$hash = base64_encode(hash('sha256', $password.$salt, true).$salt);
		$username= $row['username'];
		$setNewPassword = "UPDATE users SET pass = '". $hash ."', salt = '". $salt ."' WHERE username = '". $username ."';";
		
		//$setNewPassword = "UPDATE users SET password='". $password . "' WHERE username='". $username . "';";
		if (mysqli_query($connection, $setNewPassword) or die($setNewPassword. mysql_error())){ 
			$_SESSION['choose_form']='./landing_text.php';
		echo "<p>Your password has been updated. <a href='./main_index.php'> Click here to log in</a></p>";
		//get rid of all tokens for this user
		mysqli_query($connection, "DELETE FROM reset WHERE username='".$username."';") or die('Error deleting token'. mysql_error());
		
		}
		
	}
	nuke_session();
    //check username matches $_SESSION['get_username']
    //get rid of all reset tokens for this user.
	
	
}

?>