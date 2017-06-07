<?php
require 'database.php';
require 'sessions.php';

//This creates a token which will be emailed to the user if their details are correct.
//This token is stored on the database and can be used to reset their password

	// check if email or username exist in the database
	$msg = 0;
	if (empty($_POST['username'])) {
		$msg = 2;}
		else {
			$username = htmlspecialchars($_POST['username']);
	
			$lookup = "SELECT username, referenceID, email, forename AS firstname FROM users WHERE username = LOWER('" . $username . "');";
			echo $lookup;
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
				$firstname = $row['username'];
				$email = $row['email'];
				$hashtoken=$row['referenceID'];
			//	$datetime= time('Y-m-d hh:ss');
				//Append the email along with a GET???
				$subject= 'PACE-UP Feedback Questionnaire';
				$message=" Dear ". ucwords($firstname) . ", \n
Please click on the link to fill out our feedback questionnaire. \n
http://localhost:3702/paceup/doquest.php?token=".$hashtoken."&username=".$username." \n
Your feedback is crucial for helping us make a better app\n
If you have received this email in error, please ignore it";
				$headers = "MIME-Version: 1.0" . "r\n\ ";
				$headers .= "Content-type:text/html;charset=UTF-8"."\r\n ";
				$headers .= 'FromName: PACE-UP Next Steps'."\r\n ";
				$headers .= 'From: <noreply@paceup.org>' . "\r\n " .
						'X-Mailer: PHP/' . phpversion();				
				mail($email, $subject , $message, $headers, "-f noreply@paceup.org");
				$msg=1;
				// Use this to make sure the user is using the same device as the one used to reset the password
			}
		}
		
		echo $msg;


	
	// feedback to user.

?>
