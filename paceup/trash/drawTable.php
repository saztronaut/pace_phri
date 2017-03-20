<?php
require 'database.php';
require 'sessions.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$thisWeek= htmlspecialchars($_POST['week']); //This tells you what stage the pt is at on the pathway
$latest_t=strtotime(htmlspecialchars($_POST['latest_t'])); //The date of the latest target
$maxweekno= isset($_SESSION['week']) ? $_SESSION['week'] :htmlspecialchars($_POST['weekno']); //The max week number, i.e. the current week number
$weekno= htmlspecialchars($_POST['weekno']); //The week number for display. Not the same as the stage to allow patient autonomy
$steps = htmlspecialchars($_POST['steps']); //The latest target for steps
$daysw = htmlspecialchars($_POST['days']); //The number of days the patient is aiming to reach the target
$baseline = htmlspecialchars($_POST['base']); //The number of days the patient is aiming to reach the target

$iseven=0; // if the week is even, the form behaves slightly differently
$ispast=0; //avoid anachronistic statements if viewing a past week


if ($maxweekno>$weekno){
	$ispast=1;
    $finish_date = isset($_POST['finish']) ? $_POST['finish']:date('Y-m-d'); //For looking at historical data
} else { $finish_date=date('Y-m-d');}


$today = $finish_date;
$today_str = strtotime($today);

//start the table off
$latest_7= strtotime("+7 days", $latest_t); //7 days after the latest target
$in_7= strtotime("+7 days", $today_str); // 7 days after today - used as a time limit for displaying dates

//Create method for patient to acknowledge baseline and move on to achieving targets
if ($thisWeek=='getweek1'){ 
	setWeekOne($latest_7, $in_7, $today_str);
}

// Baseline view: oldest value shown is sign up date/ 7 days from today's date, whichever is sooner. 
$display=''; //Indicate whether to display the mean number of steps or not
$split_table = ''; //Indicate whether to display a split table, i.e. for the period displayed, there is more than 1 week to display


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
else{ // Non baseline view - show values from the last target set, i.e. in "weeks". 
	if ($weekno % 2 == 1 ||$thisWeek=='week0'){
//If the week is odd, show the 7 days from the target set
//Days since works out the date from today until the start date, which defaults at today
		$days_since =FLOOR(($today_str- $latest_t)/(60*60*24));
//The start day is typically the current date, from which you go "back in time" to get the rows to display
		$startday =  strtotime("+". $days_since ." days", $latest_t);
//$end = how many rows to iterate through in the table
		$end= $days_since;
		// Don't display the mean number of steps
		$display=0;
		$iseven=0;
	} else {
		//If it is the second week, show 7 days from the target
		$days_since= FLOOR(($today_str- strtotime("+7 days", $latest_t))/(60*60*24));	
		$n_days_since= $days_since +7;
		$startday =  strtotime("+". $n_days_since ." days", $latest_t);
		$end = $days_since;
		// Display the mean number of steps after the table
		$display=0;
		$iseven=1;
	}
}
//If you are showing more than a week, you want to display the table twice, split byt
if ($end>6){
	//echo $end;
	$n_show= CEIL(($end+1)/7); //how many tables to show
	//If $n_show is higher than 2 this will end up displaying a lot of data 
	// $n_show is the number of weeks you want to show
	if ($iseven==1){$bump=1;} else {$bump=0;}
	//$x is an integer between 0 and $n_show.
	for ($x = 0; $x <$n_show; $x++) {
	if ($x==0){
		$thisend=($end % 7); //how many days to show in the table
	    $get_start =strtotime("+". (($n_show-$x)*7)+$thisend . " days", $latest_t);
	    //$get_start is the first day of the week displayed (??)
		if ($bump==1){
			$new_week =date('Y-m-d', strtotime("+". (($n_show)*7) . " days", $latest_t));
			// Explain that user has been given extra time to hit target. give option to increase time
			echo "<div class='form-group'><p><b>You have been given an extra week to hit the target from week " .$weekno . "    ";
			echo "<button type='button' class='btn btn-default' id='increaseT' onclick=\"javascript:incTarget('".$new_week."')\">Click here to move onto the next target</button></div></form></b></p>";
		}
	    if ($ispast==1){
	    	echo "</br><h4><b>Last week</b></h4>";
	    }
	    else{
		    echo "</br><h4><b>This week</b></h4>";}

	drawTable($thisend, $display, $get_start, $daysw, $thisWeek, $steps, $username, $baseline, $weekno, $ispast);
	}
	else {
		if ($ispast==1){
			// If p is looking at steps for a time in the past, then tense as such
			echo "</br></br><h4><b>".$x ." week prior</b></h4>";;
		}
		else{
			// If it is the same week as the week shown, talk about time from now
			echo "</br></br><h4><b>".$x ." week ago</b></h4>";}
	
	$get_start =strtotime("+". ((($n_show-$x)+1)*7)-1 . " days", $latest_t) ;
	$ispast=1;
	drawTable(6, $display, $get_start, $daysw, $thisWeek, $steps, $username, $baseline,$weekno,  $ispast);}
	// separate by week
	}
		
}
else{
drawTable($end, $display, $startday, $daysw, $thisWeek, $steps, $username, $baseline, $weekno);
}
////This gives the option to view previous weeks (if they have any)

if (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==0){
	echo "<br><p><b>View your step counts from previous weeks </b></p>";
	echo " <form class = 'form-inline'> <div class='form-group'>
        <select class='form-control' placeholder='View previous step counts' id='viewSteps' name='viewSteps'>";
	for ($x = $maxweekno; $x >=0; $x--) {
		// if the week is odd, start date is the target date
		// if the week is even, the start date is the target date + 7
		echo "<option value ='". $x ."'>";
		echo "Week ". $x ;
		echo "</option>";
	}
	echo "</select></div> <div class='form-group'>";
	echo "<button type='button' class='btn btn-default' id='viewPastBtn'> View Steps </button> </div></form>";
}


//Ask how long it has been since sign up (days)
// For loop - for each day from today to either 7 or $days
// Get day of the week, date and step information
function drawTable($end, $display, $startday, $daysw, $thisWeek, $steps, $username, $baseline, $weekno, $ispast=0){
	require 'database.php';


	if ($weekno>0 && $weekno<5){
		$walkmin=15;
	}
	else {$walkmin=30;}//When you ask "Did you add a walk of $walkmin minutes or more today, reflect correct mins
	
	// $end = the number of days to display
	// $showtargets = 0/1 show the step target
	// $display = 0/1 display baseline information
	// $startday = the most recent date to display
	// $daysw = number of days in the target
	// $thisWeek = the name of the current week
	// $steps = the target number of steps
	//This is the baseline format of the table - key differences are absent: additional walk and achieved target
if ($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1'||$thisWeek=='week0'){
		echo "<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th></th></tr></thead>";
		$showtargets=0;
	}
else {
		echo "<p> Your average daily steps at baseline were <b>". $baseline ." steps</b>. This week your target is to to increase this to <b>". $steps ." steps on ". $daysw ." days per week</b></p>";
		echo "<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Did you add </br>a walk of </br>".$walkmin." minutes </br>or more </br>today?</th><th>Steps</th><th>Collection Method</th><th>Achieved </br>target</th><th></th></tr></thead>";
		$showtargets=1;
	}
	
	
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

	$resultsteps = mysqli_query($connection, $querysteps)
	or die("Can't get steps data" . mysql_error());


	$rowsteps = mysqli_fetch_array($resultsteps);
	//Give the day and date relevant
	echo "<tr><td data-title='Day'>". date('l', $x) ."</td><td data-title='Date'>";
	echo date('j-m-y', $x);
	echo "</td>";
	$key = array_search($x, $mytable);
	//If not baseline (i.e. showtargets) show data for "add walk" column

	if ($showtargets==1){
		if (isset($rowsteps['add_walk'])){
			if ($rowsteps['add_walk']==1){
			echo "<td data-title='Did you add a walk in today?' align='center'> <span id='walk". $date_set ."' ><span  class='glyphicon glyphicon-ok logo-small'></span></span></td>";}
			else {echo "<td data-title='Did you add a walk in today?' align='center'> <span id='walk". $date_set ."'></span></td>";}
		}
		else {
			echo "<td data-title='Did you add a walk in today?' align='center'> <form class = 'form-inline'> <div class='form-group'>
        <input type='checkbox' class='form-control' id='walk". $date_set ."'> </div>";
			echo "</form></td>";
		}
	}
	echo "<td data-title='Steps'>";
	if (isset($rowsteps['steps'])){
		$totalsteps= $totalsteps+ $rowsteps['steps'];
		$totaldays= $totaldays+ 1;
		echo "  <span id='steps". $date_set ."' value =". $rowsteps['steps']. " >". $rowsteps['steps']. "</span>";
	}
	else {
		echo "<form class = 'form-inline'> <div class='form-group'>
        <input type='integer' class='form-control' placeholder='Enter steps' id='steps". $date_set ."' style='width: 7em' ></div>";
		echo "</form>";
	}
	echo "</td><td data-title='Collection Method'>";
	if (isset($rowsteps['method'])){
            $give_pref= $rowsteps['method'];
	        $enabled = 'disabled';}
		else{
			$give_pref= $rowsteps['pref_method'];
			$enabled = '';
		}
		//pull in methods table to display options for ddl
		
		$methods = "SELECT methodID, method_name FROM methods;";
		$getmethods = mysqli_query($connection, $methods)
		or die("Hmm, that didn't seem to work" . mysql_error());
		
		echo "<select name='method". $key ."' id='method". $date_set ."' class='form-control' >";
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
		if ($showtargets==1){
			if (isset($steps)&&($steps<= $rowsteps['steps'])){
				echo "<td  data-title='Achieved target'  align='center'><span class='glyphicon glyphicon-star logo-small'></span></td>";
				$targetdays= $targetdays+1;
			}
			else { echo "<td  data-title='Achieved target' align='center'></td>";}
		}
		if (isset($rowsteps['steps'])){ //If there is already a step count give option to edit else option to add new
			echo "<td><input type='button' class='btn btn-default' id='editBtn". $date_set ."' value='Edit'></div></form></td>";}
		else {
		    echo "<td><input type='button' class='btn btn-default' id='saveBtn". $date_set ."' value='Add'> </div></form></td>";
		}
		echo "</tr>";
}
echo "</table></div>";
if (($totaldays!=""||isset($_POST['steps'])) && $display==1) {
// pull the baseline steps from the target
	
	if ($_POST['steps']>0) {
	
		echo "<p><b>Your average daily step count =". $_POST['steps'] ."</b>. This number is your <b>baseline steps</b><br></p><br>";
		echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";}
		else if ($thisWeek=='baseline' && $display==0) {
			echo "<p>At the end of the week the average number of steps you walked will be shown here. That number will be your <b>baseline steps</b><br></p><br>";
			echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";
		}}
		//IF not in baseline, give feedback on targets
elseif ($showtargets==1){ 
	if ($targetdays>$daysw) {
		//If they achieved over their target
	echo "<p> You have achieved your target on ". $targetdays ." days this week. You were aiming for ". $daysw ." days, well done!";}
	elseif ($targetdays==$daysw){	
		//If they achieved their target
		echo "<p> You have achieved your target on ". $targetdays ." days this week, well done!";
         }
elseif ($targetdays>0 && $targetdays<$daysw){
	//Did not achieve target
	if ($totaldays<(7-$daysw+$targetdays)){
		//If did not achieve target yet, but week still has enough time to achieve target
		if ($targetdays>1){
    echo "<p> You have achieved your target on ". $targetdays ." days so far this week, well done. See if you can do this on ". $daysw ." days this week";}
			else
			{ if($ispast==1){
				//if in the past (shouldn't occur..)
				echo "<p> You achieved your target once on this week, well done.";
			} else {
				//If did not achieve target yet, but week still has enough time to achieve target
	echo "<p> You have achieved your target once so far this week, well done. See if you can do this on ". $daysw ." days this week";}
			}
}
 else {
 	if ($targetdays>1){
 		if($ispast==1){
 			//If they achieved their target on fewer days than specified and in past
 			"<p> You achieved your target on ". $targetdays ." days this week, well done.";
 		} else{
 			//If they achieved their target on fewer days than specified and they do not have enough days this week to reach this
 	echo "<p> You have achieved your target on ". $targetdays ." days this week, well done. See if you can do this on ". $daysw ." days next week";}}
 	else 
 	//If did not achieve target yet, encouragement to achieve it next week
 	{ echo "<p> You have achieved your target once this week, well done. See if you can do this on ". $daysw ." days next week";
 }}}
else {if ($ispast==1){} else{
	echo "<p> See if you can achieve your target of ". $steps ." on ". $daysw ." days next week";}}
}
}



function setWeekOne($latest_7, $in_7, $today_str)
{$offer_dates=array(); //create array of dates starting from the end of the baseline week, to a week from now
	if ($latest_7<$in_7){
		$y=$latest_7;
		while ($y<$in_7){
			$offer_dates[]= $y;
			$y=strtotime("+1 days", $y);
		}
	}
	//Ask participant to select date to start increasing steps
	echo "<p>You should start to increase your steps now. Select a day to start from</p>";
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

		mysqli_close($connection);

		exit;
?>
