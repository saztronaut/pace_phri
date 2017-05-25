<?php

require 'database.php';
require 'sessions.php';

if ($_POST){
	$registration=htmlspecialchars($_POST['reg']);
	$username = htmlspecialchars($_SESSION['username']);
	
	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);
	
	if ($row['roleID']=="S"||$row['roleID']=="R"){
	$lookup = "SELECT `practice`, `date_rem`, `e_consent`, `e_consent_v`, `e_consent_a`, `e_consent_gp`, `e_consent_t`, `gender`, `ethnicity`, `age` 
			FROM reference
			WHERE referenceID='".$registration."';";
	$ref=mysqli_query($connection, $lookup) or die("Error getting consent data");
	if ($ref){
	$mydata=mysqli_fetch_array($ref);
	echo '{"data":'. json_encode($mydata).'}';}	

	else {echo "Error retrieving data";}
	}
	else {echo "You do not have sufficient access privileges to view this data";}
	
	
}

?>