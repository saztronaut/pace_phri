<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$username = htmlspecialchars($_SESSION['username']);
//show all the steps over time

$getDeetsq= "SELECT forename, lastname, email, practice_name, start_date, method_name, other_method, gender, ethnicity.ethnicity, age.age 
		FROM users LEFT JOIN age ON age.ageID=users.age LEFT JOIN ethnicity ON ethnicity.ethID=users.ethnicity ,practices, methods 
		WHERE users.username='".$username."' AND users.pracID=practices.pracID AND methods.methodID=users.pref_method;";
$getDeets= mysqli_query($connection, $getDeetsq) or die("Can't find user's details" . mysql_error());
$getUser = mysqli_fetch_all($getDeets, MYSQLI_ASSOC);

//For each target, output an array of the corresponding steps
//out put the group to the page
if(!empty($getUser)) {
	// feedback results
	echo json_encode($getUser);}
	else {echo 0;}

?>
