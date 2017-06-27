<?php
// link followed. Get token from link.
// check token is valid. Must exist, be less than 30 mins old and not be used already
require 'database.php';
require 'sessions.php';

$echo= "Redirecting you to password reset page";
if (isset($_GET['token'])) {	
$mytoken=htmlspecialchars($_GET['token']);
$hashedtoken = md5($mytoken);
// check token is valid
$checkToken= "SELECT * FROM reset WHERE token='". $hashedtoken . "' AND (TIME_TO_SEC(TIMEDIFF(NOW(),time_issue))/60)<30 AND used=0;";
$result= mysqli_query($connection, $checkToken) or die('Error checking token'. mysql_error());
if ($result->num_rows==0){
	echo "<p>Sorry, that password reset must have timed out. <a href='./main_index.php'>Please request another one</a></p>";
}
else{
	// tell the session the username you are setting this for
	$row = mysqli_fetch_array($result);
	$_SESSION['get_username']=$row['username'];
	// username should not be set but if it is unset it
	unset($_SESSION['username']);
	// choose new form
	//$_SESSION['choose_form']='./resetpwd.php';
	ob_start();
	header('Refresh: 1; URL = ./resetpwd.php');
	
	
}
};
// Get username from link
// Reset password
// Delete token

?>

