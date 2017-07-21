 <?php
 
 require 'database.php';
 require 'sessions.php';
// session_start();
            $msg = 0;
            if (empty($_POST['email']) || empty($_POST['password'])) {
            $msg = 2;}
            else {
			$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
			// check to see if is email
			$email_user = filter_var($email, FILTER_SANITIZE_EMAIL);
			if ($email_user!==$email){
			    $email= preg_replace("/[^a-zA-Z0-9]+/", "", $email);
			}
			
			$password = htmlspecialchars($_POST['password'], ENT_QUOTES);
			$oldpassword = MD5($password); // still use old password until all passwords updated
			$salt="";
			$hash="";
			// get salt from users table
			$getsaltq = "SELECT salt, username FROM users WHERE (LOWER(email)= LOWER('" . $email . "') OR LOWER(username) = LOWER('" . $email . "'));";
			$result = mysqli_query($connection, $getsaltq) or die('Error making select users query' . mysql_error());
			if ($result-> num_rows<1){
			    // user doesn't exist,
			    unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				unset($_SESSION["roleID"]);
			    $msg=0;
			} else {
			    $row = mysqli_fetch_array($result);
			    $salt = $row['salt'];
			    $username = $row['username'];

			    if ($salt == null) { // for current users to convert to new hashed password

			        $salt = bin2hex(openssl_random_pseudo_bytes(6));
			        $hash = base64_encode(hash('sha256', $password.$salt, true).$salt);
			        $updatePassQ = "UPDATE users SET pass = '". $hash ."', salt = '". $salt ."' WHERE username = '". $username ."' AND password = '". $oldpassword ."';";
			        mysqli_query($connection, $updatePassQ) or die('Error upgrading password' . mysql_error());
			     } else {
            // hash will become the new password			    
			   $hash = base64_encode(hash('sha256', $password.$salt, true).$salt);
			     }
			        			

	        $lookup = "SELECT username, roleID FROM users WHERE  LOWER(username) = LOWER('" . $username . "') AND pass = '" . $hash . "';";
	        $result = mysqli_query($connection,$lookup)
	          or die('Error making select users query' . mysql_error());
	        $row = mysqli_fetch_array($result);
	        if (!mysqli_query($connection, $lookup) || $result->num_rows < 1) {

				$msg = 0;
			}
			else
			{	$username = $row['username'];
				$_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $username;
                  $_SESSION['roleID'] = $row['roleID'];
				if ($row['roleID']=="R"||$row['roleID']=="S"){
					$msg= 3;
					mysqli_query($connection, "DELETE FROM sessions WHERE username='".$username."';") or die('Error deleting old session'. mysql_error());
					$token = bin2hex(openssl_random_pseudo_bytes(15));
					$hashtoken=md5($token);
					$createAdminSessionQ = "INSERT INTO sessions (username, session, timeout) VALUES ('". $username. "','". $hashtoken ."', NOW());";
					mysqli_query($connection, $createAdminSessionQ) or die ('Error creating new session');
					$_SESSION['session_token'] = $token;
			}   else {     
                   $msg= 1;}
			}
            }
                
            }
			echo $msg;           
?>      