<?php
require 'database.php';
require 'sessions.php';

//This creates a token which will be emailed to the user if their details are correct.
//This token is stored on the database and can be used to reset their password

	// check if email or username exist in the database
	$msg = 0;
	if (empty($_POST['email'])) {
		$msg = 2;}
		else {
			$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
			// check to see if is email
			$email_user = filter_var($email, FILTER_SANITIZE_EMAIL);
			if ($email_user!==$email){
			    $email= preg_replace("/[^a-zA-Z0-9]+/", "", $email);
			}
	
			$lookup = "SELECT username, email, password FROM users WHERE (email = LOWER('" . $email . "') OR username = LOWER('" . $email . "'));";
			$result = mysqli_query($connection,$lookup)
			or die('Error making select users query' . mysql_error());
			$row = mysqli_fetch_array($result);
			if (!mysqli_query($connection, $lookup) || $result->num_rows < 1) {
               /// this means there information provided was incorrect
				$msg = 0;
			}
			else
			{
		// if exists, create token
				$username = $row['username'];
				$email = $row['email'];
				$token =bin2hex(openssl_random_pseudo_bytes(15));
				$hashtoken=md5($token);
			//	$datetime= time('Y-m-d hh:ss');
				$createToken="INSERT INTO reset(token, time_issue, username, used) VALUES ('". $hashtoken ."', NOW(),'". $username ."',0);";
				#echo $createToken;
				$result= mysqli_query($connection, $createToken) or die('Error creating token'. mysql_error());
				// email token to user	
				//Append the email along with a GET???
				$subject= 'PACE-UP password reset';
				$message=" Dear ". $username . ", 
Please click on the link to reset your password.
http://www.sarahkerry.co.uk/paceup/forgotpass.php?token=".$token."
If you have received this email in error, please ignore it";
				$headers = "MIME-Version: 1.0" . "\r\n ";
				$headers .= "Content-type:text/html;charset=UTF-8"."\r\n ";
				$headers .= 'From: noreply@paceup.ac.uk' . "\r\n " .
						'X-Mailer: PHP/' . phpversion();
				mail($email, $subject , $message, $headers);
				$addEmail = "INSERT INTO emails VALUES ('". $username ."', NOW(), 'R','". $email ."');";
				mysqli_query($connection, $addEmail) or die($addEmail . mysql_error());
				$msg=1;
				// Use this to make sure the user is using the same device as the one used to reset the password
				$_SESSION['reset_user']=$username;
			}
		}
		
		echo $msg;


	
	// feedback to user.

?>
