<?php
require 'database.php';
require 'sessions.php';
//Post 12 weeks 
//Sets the value of "finish_show" in the users table to indicate whether the user has decided to stop recording steps after the 12 weeks or not. 

$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);
$username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
if ($_POST){
	
    if ($_POST['carryon']=='true'){
    	$keepgoing=2;
    }
    else {
    	$keepgoing=3;
    }

	$updateQ= "UPDATE users SET finish_show=". $keepgoing ." WHERE username='" .$username. "';";
	if (mysqli_query($connection, $updateQ)){
		$msg=1;
	} else { 
		$msg=2;
	}

}
echo $msg;
?>