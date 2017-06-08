 <?php
 
 require 'database.php';
 require 'sessions.php';
// session_start();
            $msg = 0;
            if (empty($_POST['email']) || empty($_POST['password'])) {
            $msg = 2;}
            else {
			$email = $_POST['email'];
			$password = MD5($_POST['password']);

	        $lookup = "SELECT username, password, roleID FROM users WHERE (LOWER(email) = LOWER('" . $email . "') OR LOWER(username) = LOWER('" . $email . "')) AND password = '" . $password . "';";
	        $result = mysqli_query($connection,$lookup)
	          or die('Error making select users query' . mysql_error());
	        $row = mysqli_fetch_array($result);
	        if (!mysqli_query($connection, $lookup) || $result->num_rows < 1) {
				unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				unset($_SESSION["roleID"]);
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
			echo $msg;           
?>      