<?php
require 'database.php';
require 'sessions.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$thisWeek= $_POST['week']; //This tells you what stage the pt is at on the pathway
$latest_t=strtotime($_POST['latest_t']); //The date of the latest target
$weekno= $_POST['weekno']; //The week number. Not the same as the stage to allow patient autonomy
$steps = $_POST['steps']; //The latest target for steps
$daysw = $_POST['days']; //The number of days the patient is aiming to reach the target
$baseline = $_POST['base']; //The number of days the patient is aiming to reach the target

$today =date('Y-m-d');
$today_str = strtotime($today);

//start the table off
$latest_7= strtotime("+7 days", $latest_t); //7 days after the latest target
$in_7= strtotime("+7 days", $today_str); // 7 days after today - used as a time limit for displaying dates
    if($thisWeek=='getweek1'){ //Create method for patient to acknowledge baseline and move on to achieving targets
	$offer_dates=array(); //create array of dates starting from the end of the baseline week, to a week from now
	if ($latest_7<$in_7){
		$y=$latest_7;
		while ($y<$in_7){
			$offer_dates[]= $y;
			$y=strtotime("+1 days", $y);
		}			
	}
	//Ask participant to select date to start increasing steps
	echo "<p>You should start to increase your steps now. Select a day to start increasing from.</p>";
	echo " <form class = 'form-inline'> <div class='form-group'>
        <select class='form-control' placeholder='Select day to start your program' id='setTarget' name='setTarget'>";
	foreach ($offer_dates as $x){
		$y_date=date('Y-m-d', $x);
		if ($x==$today_str){
			echo "<option selected='selected' value ='". $y_date ."'>";
			echo "Today ";
		}
		else {
			echo "<option value ='". $y_date ."'>";
			echo date('l', $x);
			echo " ";}
			echo date('d-m-Y', $x);
			echo "</option>";			
	}
	echo "</select></div> <div class='form-group'>";
	echo "<button type='button' class='btn btn-default' id='onemonthBtn'> Set date </button> </div></form>";
}
//This is the baseline format of the table - key differences are absent: additional walk and achieved target
if ($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1'){
	echo "<div class='table-responsive'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th></th></tr></thead>";
	$showtargets==0;
}
else {
	echo "<p> Your average daily steps at baseline were <b>". $baseline ." steps</b>. This week you are aiming to increase this to <b>". $steps ." steps on ". $daysw ." days per week</b></p>";
	echo "<div class='table-responsive'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Add walk?</th><th>Steps</th><th>Collection Method</th><th>Achieved target</th><th></th></tr></thead>";
	$showtargets=1;
}
// Baseline view: oldest value shown is sign up date/ 7 days from today's date, whichever is sooner. 

if 	 (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==1){
	// look for how long this user has been enrolled.
	$queryhowlong = "SELECT username, CURDATE()-start_date as days, start_date, pref_method FROM users WHERE username = '". $username ."';";

	$result = mysqli_query($connection, $queryhowlong)
	or die("Can't find user's steps" . mysql_error());

	$row = mysqli_fetch_array($result);
	$days_since = $row['days'];

	if ($days_since<=6){
		//only display values after the registration date
		$end= $days_since;
		// Don't display the mean number of steps
		$display=0;
	} else {
		//We only want to display one week at a time
		$end = 6;
		// Display the mean number of steps after the table
		$display=1;
	}
	$startday = strtotime("today");
}
else{ // Non baseline view - show values from the last target set, i.e. in "weeks". This program can be adapted to allow this kind of 
	// view but it hasn't been written in
	if ($weekno % 2 == 1){

		$days_since =FLOOR(($today_str- $latest_t)/(60*60*24));
		$startday =  strtotime("+". $days_since ." days", $latest_t);
		$end= $days_since;
		// Don't display the mean number of steps
		$display=0;
	} else {
		//If it is the second week, show 7 days from the target
		$days_since= FLOOR(($today_str- strtotime("+7 days", $latest_t))/(60*60*24));	
		$n_days_since= $days_since+7;
		$startday =  strtotime("+". $n_days_since ." days", $latest_t);
		$end = $days_since;
		// Display the mean number of steps after the table
		$display=0;
	}
}

//Ask how long it has been since sign up (days)
// For loop - for each day from today to either 7 or $days
// Get day of the week, date and step information

$mytable=array();
//Add up the number of steps as you go and the number of days that the steps are for
$totalsteps = 0;
$totaldays = 0;
$targetdays = 0;

for ($x = $end; $x >=0; $x--) {

	$daystr= "-".$x." days";
	$thisday=strtotime($daystr, $startday);
	$mytable[$x]=$thisday;
}

foreach ($mytable as $x){

	$date_set = date('Y-m-d', $x);
	$querysteps = "SELECT u.username, CURDATE()-start_date as days,  start_date, pref_method, preference, steps, add_walk, method, date_read, r.method_name
	FROM (SELECT username, start_date, pref_method, method_name as preference FROM users, methods WHERE methods.methodID=users.pref_method) as u
	LEFT JOIN (SELECT username, steps, add_walk, re.method, date_read, me.method_name FROM readings as re, methods as me  WHERE date_read = '". $date_set ."' AND re.method= me.methodID) as r
	ON u.username = r.username
	WHERE u.username = '". $username ."';";
	//	echo $querysteps;
	$resultsteps = mysqli_query($connection, $querysteps)
	or die("Can't get steps data" . mysql_error());


	$rowsteps = mysqli_fetch_array($resultsteps);
	//Give the day and date relevant
	echo "<tr><td>". date('l', $x) ."</td><td>";
	echo date('j-m-y', $x);
	echo "</td><td>";
	$key = array_search($x, $mytable);
	if (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==0){
		if (isset($rowsteps['add_walk'])){
			if ($rowsteps['add_walk']==1){
			echo " <span class='glyphicon glyphicon-ok logo-small' id='walk". $key ."' ></span>";}
			else {echo " <span id='walk". $key ."'></span>";}
		}
		else {
			$key = array_search($x, $mytable);
			echo "<form class = 'form-inline'> <div class='form-group'>
        <input type='checkbox' class='form-control' id='walk". $key ."'> </div>";
			echo "</form>";
		}
		echo "</td><td>";
	}
	if (isset($rowsteps['steps'])){
		$totalsteps= $totalsteps+ $rowsteps['steps'];
		$totaldays= $totaldays+ 1;
		echo " <span id='steps". $key ."' value =". $rowsteps['steps']. " >". $rowsteps['steps']. "</span>";
	}
	else {
		echo "<form class = 'form-inline'> <div class='form-group'>
        <input type='integer' class='form-control' placeholder='Enter steps' id='steps". $key ."' style='width: 7em' ></div>";
		echo "</form>";
	}
	echo "</td><td>";
	if (isset($rowsteps['method'])){
            $give_pref= $rowsteps['method'];}
		else{
			$give_pref= $rowsteps['pref_method'];
		}
		//pull in methods table to display options for ddl
		
		$methods = "SELECT methodID, method_name FROM methods;";
		$getmethods = mysqli_query($connection, $methods)
		or die("Hmm, that didn't seem to work" . mysql_error());
		
		echo "<select name='method". $key ."' id='method". $key ."' class='form-control' >";
		while ($drawmethods = mysqli_fetch_array($getmethods, MYSQLI_ASSOC)) {
			if ($drawmethods['methodID']==$give_pref){
				echo "<option selected='selected' value='". $drawmethods['methodID'] ."'> ". $drawmethods['method_name'] ." </option> ";
			}
			else{
				echo "<option value='". $drawmethods['methodID'] ."'> ". $drawmethods['method_name'] ." </option> ";}
		}
		
		echo "</select>";
		
		echo "</td>";
		///Get stars
		if (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==0){
			if (isset($steps)&&($steps< $rowsteps['steps'])){
				echo "<td><span class='glyphicon glyphicon-star logo-small'></span></td>";
				$targetdays= $targetdays+1;
			}
			else { echo "<td></td>";}
		}
		if (isset($rowsteps['steps'])){ //If there is already a step count give option to edit else option to add new
			echo "<td><input type='button' class='btn btn-default' id='editBtn". $key ."' value='Edit'></div></form></td>";}
		else {
		    echo "<td><input type='button' class='btn btn-default' id='saveBtn". $key ."' value='Add'> </div></form></td>";
		}
		echo "</tr>";
}
echo "</table></div>";
if (($totaldays!=""||isset($_POST['steps'])) && $display==1) {
	$avgsteps= round($totalsteps/$totaldays);
	$avgsteps= ceil($avgsteps/50)*50;
	if ($_POST['steps']!= $avgsteps) {
		$avgsteps=$_POST['steps'];	}

		echo "<p><b>Your average daily step count =". $avgsteps ."</b>. This number is your <b>baseline steps</b><br></p><br>";
		echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";}
		else if ($thisWeek=='baseline' && $display==0) {
			echo "<p>At the end of the week the average number of steps you walked will be shown here. That number will be your <b>baseline steps</b><br></p><br>";
			echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";
		}
elseif ($showtargets==1){ 
	if ($targetdays>$daysw) {
		//echo "<p> Target days:" . $daysw . ". Days reached target ". $targetdays . " </p>";
	echo "<p> You have achieved your target on ". $targetdays ." days this week. You were aiming for ". $daysw ." days, well done!";}
	elseif ($targetdays==$daysw){	
		//echo "<p> Target days:" . $daysw . ". Days reached target ". $targetdays . " </p>";
		echo "<p> You have achieved your target on ". $targetdays ." days this week, well done!";
         }
elseif ($targetdays>0 && $targetdays<$daysw){
	if ($totaldays<(7-$daysw+$targetdays)){
		if ($targetdays>1){
    echo "<p> You have achieved your target on ". $targetdays ." days so far this week, well done. See if you can do this on ". $daysw ." days this week";}
			else
			{ 
	echo "<p> You have achieved your target once so far this week, well done. See if you can do this on ". $daysw ." days this week";
			}
}
 else {
 	if ($targetdays>1){
 	echo "<p> You have achieved your target on ". $targetdays ." days this week, well done. See if you can do this on ". $daysw ." days next week";}
 	else 
 	{ echo "<p> You have achieved your target on ". $targetdays ." day this week, well done. See if you can do this on ". $daysw ." days next week";
 }}}
else {echo "<p> See if you can achieve your target of ". $steps ." on ". $daysw ." days next week";}
}


		mysqli_close($connection);

		exit;
?>