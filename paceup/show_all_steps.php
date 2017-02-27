<?php
require 'database.php';
require 'sessions.php';

$username = htmlspecialchars($_SESSION['username']);
//show all the steps over time

$myStepsprint=[];
$myTargetsprint=[];
$getTargetsq= "SELECT date_set, steps, days FROM targets WHERE username='". $username ."' ORDER BY date_set;";
$getTargets= mysqli_query($connection, $getTargetsq) or die("Can't find user's targets" . mysql_error());
//$target_row= mysqli_fetch_array($getTargets);

//For each target, output an array of the corresponding steps
$counter=0;
while ($target_row = mysqli_fetch_array($getTargets, MYSQLI_ASSOC)){
    $myTargetsprint[]= $target_row;
    $getdate= $target_row['date_set'];
    $getStepsq=  "SELECT ".$counter.", date, add_walk, steps as steps, method, date_set, ". $target_row['steps']. " as target, ". $target_row['days']." as days FROM
    		(SELECT date_read as date, add_walk, steps as steps, method, MAX(date_set) as date_set FROM
           (SELECT  date_read, date_entered, add_walk, r.steps, method, date_set, t.steps as target FROM readings as r, targets as t WHERE r.username= t.username AND r.username='". $username."' AND date_read>=date_set) AS getTargets
           GROUP BY date_read) as consolidate WHERE date_set='". $getdate ."';";

    $getSteps= mysqli_query($connection, $getStepsq) or die("Can't find user's steps" . mysql_error());
    $step_row = mysqli_fetch_all($getSteps, MYSQLI_ASSOC);
    $myStepsprint[$counter]= $step_row;	
    
    $counter=$counter+1;

}
//out put the group to the page
if(!empty($myStepsprint)&&!empty($myTargetsprint)) {
	// feedback results
	$step_array = $myStepsprint;
	$result_array = $myTargetsprint;
	echo '{"targets":'.json_encode($result_array). ',"steps":'. json_encode($step_array).'}';}
	else {echo 0;}

?>
