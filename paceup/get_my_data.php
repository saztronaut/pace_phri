<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$username = htmlspecialchars($_SESSION['username']);
//show all the steps over time

$getDeetsq= "SELECT forename, lastname, email, practice_name, start_date, method_name, other_method, gender, ethnicity.ethnicity, age.age FROM users, practices, methods, age, ethnicity WHERE users.username='". $username ."' AND users.pracID=practices.pracID AND methods.methodID=users.pref_method AND age.ageID=users.age AND ethnicity.ethID=users.ethnicity;";
$getDeets= mysqli_query($connection, $getDeetsq) or die("Can't find user's details" . mysql_error());
$getUser = mysqli_fetch_all($getDeets, MYSQLI_ASSOC);

//For each target, output an array of the corresponding steps
//out put the group to the page
if(!empty($getUser)) {
	// feedback results
	echo json_encode($getUser);}
	else {echo 0;}

?>
