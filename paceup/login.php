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
			}   else{     
                   $msg= 1;}
			}
            }
			echo $msg;           
?>      