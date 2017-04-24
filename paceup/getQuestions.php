<?php
require 'database.php';
require 'sessions.php';

$results=[];
if ($_POST){
	
	$username = htmlspecialchars($_SESSION['username']);
	
	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);
	
	if ($row['roleID']=="S"||$row['roleID']=="R"){
		$myQuery= "SELECT * FROM questions;";
		$results= mysqli_query($connection, $myQuery) or die("Error getting questions");
		if($results->num_rows>0){
			$myarray=mysqli_fetch_array($results);
			echo json_encode($myarray);
		} else {echo 0;}
		 
		
	}
	else{
		echo "You do not have the access privileges to change the feedback questions";
	}
}

?>


