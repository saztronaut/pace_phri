<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

$getUser = [];
if ($_POST){
//	$registration=htmlspecialchars($_POST['reg']);
	$username = htmlspecialchars($_POST['username']);
    $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);	
	$auth = checkRights('R');
	
	if ($auth==1){
		
	//show all the steps over time

	$getDeetsq= "SELECT forename, lastname, email, practice_name, start_date, method_name, other_method, reference.gender, ethnicity.ethnicity, age.age 
		FROM users ,practices, methods, reference LEFT JOIN age ON age.ageID=reference.age LEFT JOIN ethnicity ON ethnicity.ethID=reference.ethnicity 
		WHERE users.username='".$username."' AND users.pracID=practices.pracID AND methods.methodID=users.pref_method AND users.referenceID=reference.referenceID;";
	$getDeets= mysqli_query($connection, $getDeetsq) or die("Can't find user's details" . mysql_error());
	$getUser = mysqli_fetch_array($getDeets, MYSQLI_ASSOC);
	
	$getEmailsq= "SELECT username, purpose_name, time_sent FROM emails, email_purpose WHERE emails.purpose=email_purpose.purpose AND username='".$username."';";
	$getEmails= mysqli_query($connection, $getEmailsq) or die("Can't find user's emails" . mysql_error());
	$userEmails = mysqli_fetch_all($getEmails, MYSQLI_ASSOC);
	
	$getReadingq= "SELECT date_read, date_entered, steps FROM readings WHERE username='".$username."' AND date_read IN (SELECT MAX(date_read) FROM readings WHERE username='".$username."');";
	$getReading= mysqli_query($connection, $getReadingq) or die($getReadingq . mysql_error());
	$recentSteps = mysqli_fetch_all($getReading, MYSQLI_ASSOC);
	
	$getTargetq= "SELECT date_set, days, steps FROM targets WHERE username='".$username."' AND date_set IN (SELECT MAX(date_set) FROM targets WHERE username='".$username."');";
	$getTarget= mysqli_query($connection, $getTargetq) or die($getTargetq . mysql_error());
	$target = mysqli_fetch_all($getTarget, MYSQLI_ASSOC);
	
	}
}
//For each target, output an array of the corresponding steps
//out put the group to the page
if(!empty($getUser)) {
	// feedback results
	echo '{"userDetails":'.json_encode($getUser).', "emails":'.json_encode($userEmails).', "lastSteps":'.json_encode($recentSteps).', "target":'.json_encode($target).'}';}
	else {echo 0;}

?>
