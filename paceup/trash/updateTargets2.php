<!DOCTYPE html >
<!-- OBSELETE -->
<html lang="en">
<?php
require 'database.php';
require 'sessions.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

//get week
$get_week= "SELECT COUNT(*) as n_t, MAX(date_set) as latest_t, steps FROM targets WHERE username='". $username ."' ORDER BY date_set DESC;";
// n_t gives the number of targets that are in the targets table
// latest_t gives the date set of the most recent target
// steps give the steps at the most recent target
// days is the number of days the target was for
$result = mysqli_query($connection, $get_week)
or die("Can't find user week" . mysql_error());
$row = mysqli_fetch_array($result);
$numt = $row['n_t'];
$getsteps= $row['steps'];
if ($numt==1||$numt==3){
	$days=3;
	$steptarget=$getsteps+1500;
}
elseif ($numt==2||$numt==4){
	$days=5;
	$steptarget=$getsteps;
}
elseif ($numt>5){
	$days=6;
	$steptarget=$getsteps;
}
 
	$endEvenWeek = "SELECT COUNT(*) as achieved, days, DATE_ADD(date_set, INTERVAL 14 DAY) as date14
					FROM readings as r,
					(SELECT username, steps as target, date_set, days  FROM targets WHERE username='". $username ."' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set DESC)) as t
					WHERE r.username=t.username AND r.date_read between (t.date_set+7) AND (t.date_set+14) AND r.steps>=t.target;";
	$getEndWeek= mysqli_query($connection, $endEvenWeek);
	$row2 = mysqli_fetch_array($getEndWeek);
	$achieved = $row2['achieved'];
	$goal = $row2['days'];
//	if (($achieved>=$goal) && isset($achieved)){
//		$date_set = $row2['date14'];
//		$onem_target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
//		$gettarget = mysqli_query($connection, $onem_target);
//	}

	?>
