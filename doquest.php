<?php
// link followed. Get token from link.
require 'database.php';
require 'sessions.php';


$echo= "Redirecting you to Questionnaire page";
if (isset($_GET['token'])) {	
$mytoken=htmlspecialchars($_GET['token']);
$token=$mytoken;
$user=htmlspecialchars($_GET['username']);
// check token is valid
$checkToken= "SELECT username FROM users WHERE referenceID='". $token . "' AND  username='". $user . "';";
echo $checkToken;
$result= mysqli_query($connection, $checkToken) or die('Error checking token'. mysql_error());
if ($result->num_rows==0){
	echo "<p>That code seems to be invalid, please <a href='./informationsheet2.php'>contact us</a> or login in <a href='./main_index.php'> log in</a></p>";
}
else{
	// tell the session the username you are setting this for
	$row = mysqli_fetch_array($result);
	$_SESSION['get_username']=$row['username'];
	// username should not be set but if it is unset it
	unset($_SESSION['username']);
	// choose new form
	//$_SESSION['choose_form']='./resetpwd.php';
	header('Refresh: 1; URL = ./feedbackQuestionnaire.php');
	
	
}
};
// Get username from link
// Reset password
// Delete token

?>

