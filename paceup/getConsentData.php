<?php
require 'database.php';
require 'sessions.php';
include 'checkUserRights.php';

if ($_POST){
	$registration=htmlspecialchars($_POST['reg'], ENT_QUOTES);
  $registration = preg_replace("/[^a-zA-Z0-9]+/", "", $registration);
	$username = htmlspecialchars($_SESSION['username']);
  $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);	
	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$auth = checkRights('R');
	
	if ($auth==1){
	$lookup = "SELECT `practice`, `date_rem`, `e_consent`, `e_consent_v`, `e_consent_a`, `e_consent_gp`, `e_consent_t`, `gender`, `ethnicity`, `age` 
			, username, forename, lastname
FROM reference LEFT JOIN users on reference.referenceID = users.referenceID 
			WHERE reference.referenceID='".$registration."';";
	$ref=mysqli_query($connection, $lookup) or die("Error getting consent data");
	if ($ref){
	$mydata=mysqli_fetch_array($ref);
	echo '{"data":'. json_encode($mydata).'}';}	

	else {echo "Error retrieving data";}
	}
	else {echo "You do not have sufficient access privileges to view this data";}
	
	
}

?>