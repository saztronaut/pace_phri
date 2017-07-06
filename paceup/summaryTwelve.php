<?php

require 'database.php';
require 'sessions.php';

// Show the twelve week feedback summary for a user
$username = htmlspecialchars($_SESSION['username']);
$summary=[];
// Report the baseline week
// Baseline week
$baseline= "SELECT date_set, steps FROM targets WHERE username='". $username."' AND days=0;";
$getbase= mysqli_query($connection, $baseline) or die ($baseline);
$results= mysqli_fetch_array($getbase);
$date_base= $results['date_set'];
$baseline_steps= $results['steps'];

$baseline_a= [];
$baseline_a['baseline']=$date_base;
$baseline_a['mean_steps']= $baseline_steps;
$summary[0]=$baseline_a;
$summary['achieved_w']=0;
$summary['achieved_d']=0;
// Get date of first week. 
$getWeekOne= "SELECT date_set, steps, days FROM targets WHERE username='". $username."'  ORDER BY date_set LIMIT 1, 1;";
$w1=mysqli_query($connection, $getWeekOne);
$w1Results= mysqli_fetch_array($w1);
$week1_date= $w1Results['date_set'];
$target= $w1Results['steps'];
$days=  $w1Results['days'];


// Get date of week 13
$order= 7;
$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
$get_steps_date = mysqli_query($connection, $get_date)
or die("Can't get steps data" . mysql_error());
$w13 = mysqli_fetch_array($get_steps_date); 
$week13=$w13['date_set'];
if ($week13 == null){ // if no target for week 13 has been set, then get the last recorded reading and report that
		$getLatestReadingq = "SELECT MAX(date_read) as recent FROM readings WHERE username='". $username ."';";
		$getLatestReading= mysqli_query($connection, $getLatestReadingq) or die ("can't get latest reading".mysql_error());
		$latestReading= mysqli_fetch_array($getLatestReading);
		$week13 = $latestReading['recent']; // replace the value for week13 with the last step recorded.
	
}

// how many weeks to display
$n_weeks=(strtotime($week13)-strtotime($week1_date))/(60*60*24*7);
$summary['n_weeks']= $n_weeks;

for ($x = 0; $x <$n_weeks; $x++) {
	$a=$x*7;
	$b=(($x+1)*7)-1;
	
	$thisDate=date('Y-m-d', strtotime("+". $a ." days", strtotime($week1_date)));
	$thisDateFin=date('Y-m-d', strtotime("+". $b ." days", strtotime($week1_date)));
	// get number of readings
	$getWeek = "SELECT COUNT(*) AS n_days, SUM(steps) AS total_steps, ROUND(AVG(steps), 0) AS mean_steps, COUNT(add_walk) AS walk 
               FROM (SELECT date_read, add_walk, steps FROM readings 
               WHERE username='". $username ."' AND date_read BETWEEN '". $thisDate ."' AND '". $thisDateFin."') AS thisWeek;";
	$getThisWeek= mysqli_query($connection, $getWeek);
	$theseResults= mysqli_fetch_array($getThisWeek);
	$week=[];
	
	$week['total_steps']=$theseResults['total_steps'];
	if ($week['total_steps']==null){
		$week['total_steps']=0;
	}
	$week['mean_steps'] = $theseResults['mean_steps'];
	if ($week['mean_steps']==null){
		$week['mean_steps']=0;
	}
	$week['n_days']=$theseResults['n_days'];
	$week['walk']=$theseResults['walk'];
	//get this weeks target and update $target if there is one
	$thisTarget ="SELECT steps, days from targets WHERE username='". $username ."' AND date_set='".$thisDate."';";
	$getThisTarget= mysqli_query($connection, $thisTarget);
	if ($getThisTarget->num_rows==1){
		$newTarget=mysqli_fetch_array($getThisTarget);
		$target= $newTarget['steps'];
		$days= $newTarget['days'];
	}
	// get number of days that target was hit
	$getTargetdays = "SELECT COUNT(*) AS n_days
               FROM (SELECT date_read, add_walk, steps FROM readings
               WHERE username='". $username ."' AND steps>=". $target ." AND date_read BETWEEN '". $thisDate ."' AND '". $thisDateFin."') AS thisWeek;";
	$daysTarget= mysqli_query($connection, $getTargetdays);
	$targetResults= mysqli_fetch_array($daysTarget);
	$week['achieved_t']= $targetResults['n_days'];
	$week['target']= $target;
	$week['targetdays']= $days;
	$week['date']= $thisDate;
	$summary['achieved_d']= $summary['achieved_d'] + $targetResults['n_days'];
	if ($week['targetdays']<=$week['achieved_t']){
	$summary['achieved_w']= $summary['achieved_w']+1;}
	$summary[$x+1]=$week;

}
//Average number of steps at baseline
$baseStepsQ = "SELECT COUNT(*) AS n_days, SUM(steps) AS total_steps, ROUND(AVG(steps), 0) AS mean_steps, COUNT(add_walk) AS walk
               FROM (SELECT date_read, add_walk, steps FROM readings
               WHERE username='". $username ."' AND date_read BETWEEN '". $date_base."' AND DATE_ADD('". $date_base."', INTERVAL 6 DAY)) AS thisWeek;";
$getBaseSteps = mysqli_query($connection, $baseStepsQ);
$mybaseline= mysqli_fetch_array($getBaseSteps);
$summary['base_total']= $mybaseline['total_steps'];
$summary['base_days']= $mybaseline['n_days'];

$totalStepsQ = "SELECT COUNT(*) AS n_days, SUM(steps) AS total_steps, ROUND(AVG(steps), 0) AS mean_steps, COUNT(add_walk) AS walk
               FROM (SELECT date_read, add_walk, steps FROM readings
               WHERE username='". $username ."' AND date_read BETWEEN '". $week1_date ."' AND '". $week13."') AS thisWeek;";
$getTotalSteps = mysqli_query($connection, $totalStepsQ);
$mytotal= mysqli_fetch_array($getTotalSteps);
$summary['total_days']= $mytotal['n_days'];
$summary['total_avg']= $mytotal['mean_steps'];
$summary['total_steps']= $mytotal['total_steps'];
$summary['add_walk']= $mytotal['walk'];
// Then report each week sequentially

if (!empty($summary)) {
	// feedback results
	$result_array = $summary;
	echo json_encode($result_array);}
	else {
		echo 0;
	}

	
?>