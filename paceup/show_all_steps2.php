<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$myStepsprint=[];
$myTargetsprint=[];

if (isset($_SESSION['username'])){
$username = htmlspecialchars($_SESSION['username']);
//show all the steps over time

//first target date should be the beginning date
//today would be the last date
$today=date('Y-m-d');


$getTargetsq= "SELECT date_set, steps, days FROM targets WHERE username='". $username ."' AND date_set<=CURDATE() ORDER BY date_set;";
$getTargets= mysqli_query($connection, $getTargetsq) or die("Can't find user's targets" . mysql_error());

//For each target, output an array of the corresponding steps
$counter=0;
//$nTargets=$getTargets->num_rows;

while ($target_row = mysqli_fetch_array($getTargets, MYSQLI_ASSOC)){
	if ($counter==0){
		$initaldate=$target_row['date_set'];
	}
    $myTargetsprint[]= $target_row;}
    
    //now many targets are there
    $n_targets=count($myTargetsprint)-1;
// Start with the first target 
    
    for ($i=0; $i<=($n_targets); $i++){
    $target_row=$myTargetsprint[$i];
 
    $getdate= $target_row['date_set'];

    $getStepsq=  "SELECT ".$counter.", date, add_walk, steps as steps, method, date_set, ". $target_row['steps']. " as target, ". $target_row['days']." as days FROM
    		(SELECT date_read as date, add_walk, steps as steps, method, MAX(date_set) as date_set FROM
           (SELECT  date_read, date_entered, add_walk, r.steps, method, date_set, t.steps as target FROM readings as r, targets as t WHERE r.username= t.username AND r.username='". $username."' AND date_read>=date_set) AS getTargets
           GROUP BY date_read) as consolidate WHERE date_set='". $getdate ."' ORDER BY date;";
    if ($i==$n_targets){
    $enddate= $today;}
    else{
    	$nexttar=$myTargetsprint[$i+1];
    	$enddate=$nexttar['date_set'];
    }
    // get the date of the newest record. 
    // get the difference between that date and date_set
    $gap=date_diff(date_create($getdate),date_create($enddate));
    // round it up to the nearest multiple of 7
    $ndays=(CEIL($gap->d/7))*7;

    $mySteps=[];
    $stepcount=0;    
    $getSteps=mysqli_query($connection, $getStepsq) or die("Can't find user's steps" . mysql_error());    

    while ($step_row= mysqli_fetch_array($getSteps, MYSQLI_ASSOC)){
    	//if the date_read is higher than the date indicated by step count, then you need to add a new row
    	while (date('Y-m-d', strtotime("+". $stepcount ." days", strtotime($getdate)))<$step_row['date']){
    		$mySteps[]=date('Y-m-d',strtotime("+". $stepcount ." days", strtotime($getdate)));
    		$stepcount= $stepcount+1;
    	}
    	
    	$mySteps[]=$step_row;
    	$stepcount= $stepcount+1;
    }
    
    //$step_row = mysqli_fetch_all($getSteps, MYSQLI_ASSOC);
    $myStepsprint[$counter]= $mySteps;	
    
    $counter=$counter+1;
    

}}
mysqli_free_result($getTargets);

//out put the group to the page
if(!empty($myStepsprint)&&!empty($myTargetsprint)) {
	// feedback results
	$step_array = $myStepsprint;
	$result_array = $myTargetsprint;
	echo '{"targets":'.json_encode($result_array). ',"steps":'. json_encode($step_array).'}';}
	else {echo 0;}

	mysqli_close($connection);
	
	exit;
	?>
