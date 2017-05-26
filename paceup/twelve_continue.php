<?php

require 'database.php';
require 'sessions.php';

$username = htmlspecialchars($_SESSION['username']);
$msg=0;
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
} else { $msg=2;}

}
echo $msg;
?>