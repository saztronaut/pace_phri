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
$setweekone=0; //return whether the user must set week one target
$n_show=0; //default number of extra weeks to show
$bump=0;

$getTable=[]; //array to parse information back to the steps page to be drawn as table

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
	$setweekone=1;
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
$tableResults=[];
//If you are showing more than a week, you want to display the table twice, split byt
if ($end>6){
	$split_table=1;
	//echo $end;
	$n_show= CEIL(($end+1)/7); //how many tables to show
	//If $n_show is higher than 2 this will end up displaying a lot of data 
	// $n_show is the number of weeks you want to show
	if ($iseven==1 && $ispast==0){$bump=1;} else {$bump=0;}
	//$x is an integer between 0 and $n_show.
	for ($x = 0; $x <$n_show; $x++) {
	if ($x==0){
		$thisend=($end % 7); //how many days to show in the table
	    $get_start =strtotime("+". (($n_show-$x)*7)+$thisend . " days", $latest_t);
	    //$get_start is the first day of the week displayed (??)
		if ($bump==1){
			$new_week =date('Y-m-d', strtotime("+". (($n_show)*7) . " days", $latest_t));
			// Explain that user has been given extra time to hit target. give option to increase time
			
		//	echo "<div class='form-group'><p><b>You have been given an extra week to hit the target from week " .$weekno . "    ";
		//	echo "<button type='button' class='btn btn-default' id='increaseT' onclick=\"javascript:incTarget('".$new_week."')\">Click here to move onto the next target</button></div></form></b></p>";
		}
	    if ($ispast==1){
	    	//echo "</br><h4><b>Last week</b></h4>";
	    }
	    else
	    {    //echo "</br><h4><b>This week</b></h4>";
	    }
	$tableResults[$x]=drawTable($thisend, $display, $get_start, $daysw, $thisWeek, $steps, $username, $baseline, $weekno, $ispast);
	}
	else {
		if ($ispast==1){
			// If p is looking at steps for a time in the past, then tense as such
		//	echo "</br></br><h4><b>".$x ." week prior</b></h4>";
		}
		else{
			// If it is the same week as the week shown, talk about time from now
		//	echo "</br></br><h4><b>".$x ." week ago</b></h4>";
		}
	
	$get_start =strtotime("+". ((($n_show-$x)+1)*7)-1 . " days", $latest_t) ;
	$ispast=1;
	$tableResults[$x]=drawTable(6, $display, $get_start, $daysw, $thisWeek, $steps, $username, $baseline, $weekno,  $ispast);}
	// separate by week
	}
		
}
else{
	$tableResults[0]=drawTable($end, $display, $startday, $daysw, $thisWeek, $steps, $username, $baseline, $weekno);
}

$getTable['iseven'] = $iseven;
$getTable['ispast'] = $ispast;
$getTable['displayavg'] = $display;
$getTable['splittable'] = $split_table;
$getTable['n_show'] = $n_show;
$getTable['setweekone'] = $setweekone;
$getTable['latest_7']= $latest_7;
$getTable['in_7']= $in_7;
$getTable['today_str']= $today_str;
$getTable['bump']= $bump;
$getTable['tableResults']= $tableResults;

//out put the group to the page
if(!empty($getTable)) {
	// feedback results
	$result_array = $getTable;
	echo json_encode($result_array);}
	else {echo 0;}



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
	//	echo "<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th><th></th></tr></thead>";
	//	$showtargets=0;
	}
else {
	//	echo "<p> Your average daily steps at baseline were <b>". $baseline ." steps</b>. This week your target is to to increase this to <b>". $steps ." steps on ". $daysw ." days per week</b></p>";
	//	echo "<div class='table'> <table class='table table-plain'><thead><tr><th>Day</th><th>Date</th><th>Did you add </br>a walk of </br>".$walkmin." minutes </br>or more </br>today?</th><th>Steps</th><th>Collection Method</th><th>Achieved </br>target</th><th></th></tr></thead>";
	//	$showtargets=1;
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
$table=[];
$myrow=[];
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
	$day= date('l', $x);
	$stepdate= date('j-m-y', $x);
	$key = $end-array_search($x, $mytable);
	//If not baseline (i.e. showtargets) show data for "add walk" column
	$addwalk = $rowsteps['add_walk'];
	$stepsread = $rowsteps['steps'];


	if (isset($rowsteps['steps'])){
		$totalsteps= $totalsteps+ $rowsteps['steps'];
		$totaldays= $totaldays+ 1;
	}

	if (isset($rowsteps['method'])){
            $give_pref= $rowsteps['method'];
	        $enabled = 'disabled';}
		else{
			$give_pref= $rowsteps['pref_method'];
			$enabled = '';
		}

        $temp=[];
		$temp['date_set']=$date_set;
		$temp['day']=$day;
		$temp['stepdate']=$stepdate;
		$temp['addwalk']=$addwalk;
		$temp['stepsread']=$stepsread;
		$temp['give_pref']=$give_pref;
		$myrow[$key]=$temp;
		
}

$table['showrow']=$myrow;
$table['ispast']=$ispast;
$table['end']=$end;
return $table;
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