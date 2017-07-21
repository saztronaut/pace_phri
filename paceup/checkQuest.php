<?php
require 'database.php';
require 'sessions.php';

$msg=0;
$check12=0;
if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
	$username = htmlspecialchars($_SESSION['ape_user']);
    $username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
}
else if (isset($_SESSION['username'])){
	$username = htmlspecialchars($_SESSION['username']);
	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$check12 = 1;
}
else if ( isset($_SESSION['get_username'])) {
	$username = htmlspecialchars($_SESSION['get_username']);
	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$check12 = 0; // if accessed through get, that means user has been requested to do quest i.e. before 12
	
}

if (isset($username)){
    $lookup = "SELECT username FROM questionnaire WHERE username='" . $username . "';";
    $result = mysqli_query($connection, $lookup) or die(0);
    

    if ($result -> num_rows==0){
    	$msg = 1; //no questionnaire recorded so show questionnaire
    } else if ($result -> num_rows == 1) {
    	$msg = 2; //questionnaire recorded
    }
    if ($check12){
    	$lookup = "SELECT finish_show FROM users WHERE username='" . $username . "' AND finish_show !=0;";
    	$result = mysqli_query($connection, $lookup) or die(0);
    	if ($result -> num_rows==0){
    		$msg = 3; //not finished set and not accessed through GET
    	}
    	
    }
    
    mysqli_free_result($result);

} else {
	$msg = 0;
}

echo $msg;


?>