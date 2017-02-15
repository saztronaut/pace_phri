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

	        $lookup = "SELECT username, password FROM users WHERE (email = LOWER('" . $email . "') OR username = LOWER('" . $email . "')) AND password = '" . $password . "';";
	        $result = mysqli_query($connection,$lookup)
	          or die('Error making select users query' . mysql_error());
	        $row = mysqli_fetch_array($result);
	        if (!mysqli_query($connection, $lookup) || $result->num_rows < 1) {
				unset($_SESSION["username"]);
				unset($_SESSION["password"]);
				$msg = 0;
			}
			else
			{	        
				$username = $row['username'];
				$_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $username;
                  $msg= 1;
                  $_SESSION['choose_form']= 'steps.php';
                  
                     header('Refresh: 0; URL = main_index.php');
			}
			}
			echo $msg;           
         ?>      