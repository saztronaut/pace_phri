<?php

function getWeek(){
	require 'database.php';
//	require 'sessions.php';

	//Query the database to find out where the participant is in terms of targets and weeks.
	//If no target, the participant is at baseline
	//If has baseline "target" - i.e. baseline measurement alone, then they have not been properly introduced to week 1 so they need
	//to see the text about how the targets are increasing and how this is week 1.
	//Participants can delay the start of week one to let them have a logical week i.e. start on Monday so this may also happen
	//Particpants who have finished baseline should not be able to change the baseline values
	//If p has baseline & week 1 targets then they are on either week 1 or week 2 or week 2+ and this can be ascertained by
	//Looking at the time difference between the target setting and the curdate.
	//And so on for the remaining weeks
	// If there is no baseline target, add if needed
	$baseline_target = "INSERT INTO targets (username, date_set, steps, days)
                      SELECT getDays.username, getDays.start, getDays.base_steps, 0
                      FROM
                      (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
                      FROM (SELECT r.date_read, m.steps, r.username
                      FROM readings as r,
                      readings as m
                      WHERE r.date_read<= m.date_read AND DATEDIFF(r.date_read, m.date_read)<7 AND r.username= m.username) as getValues
                      GROUP BY getValues.date_read, getValues.username) as getDays
                      WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6 AND getDays.username NOT IN
                      (SELECT username FROM targets);";
	
	$getbase= mysqli_query($connection, $baseline_target);
	$_SESSION['week']='baseline';
	$today =date('Y-m-d');
	$today_str = strtotime($today);
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
	 
	$get_week= "SELECT COUNT(*) as n_t, MAX(date_set) as latest_t, steps, days FROM targets WHERE username='". $username ."' ORDER BY date_set DESC;";
	$result = mysqli_query($connection, $get_week)
	or die("Can't find user week" . mysql_error());
	$row = mysqli_fetch_array($result);
	$latest_t=strtotime($row['latest_t']);
	if ($row['n_t']==0){
		$_SESSION['week']='baseline';
		echo $_SESSION['week'];
	}
	else {
		if ($row['n_t']==1){
			$_SESSION['week']='getweek1';
			$w=1;
		}
		elseif ($row['n_t']>1 && $row['n_t']<13 ){
			$w=((($row['n_t'])-2)*2)+1;
			if ($latest_t> $today_str){
				$_SESSION['week']='delayweek'.$w;
			}
			elseif (strtotime('+6 days', $latest_t) > $today_str ){
				$_SESSION['week']="week".$w;}
				else {
					$w=$w+1;
					$_SESSION['week']="week".$w;}
		}
		else {$_SESSION['week']="week13";}
		$_SESSION['steps']=$row['steps'];
		$_SESSION['days']=$row['days'];
		$_SESSION['latest_t']=$row['latest_t'];
		$_SESSION['weekno']=$w;
		echo $w;

	}
	//so now session contains a value for week which is:
	//baseline - show baseline week information,
	//getweek1 - introduce steps and show week 1. Give option to delay/ alter week1 start
	//delayweek - will show baseline steps view, will show baseline steps as static value, will say "you will increase your steps on X"
	//weekX - odds - will show target, will compare steps with target, will inform of baseline steps, will give other information
	//weekX - evens - will show target, will compare target with steps, if the p not reaching target then offer deferrment of level up
	//week13 - patients who have completed the course...
}


function drawTableContents(){
	require 'database.php';
	//  	require 'sessions.php';
	echo $_SESSION['week'];
	$today =date('Y-m-d');
	$today_str = strtotime($today);
	$latest_t=strtotime($_SESSION['latest_t']);
	
	//start the table off
	$thisWeek = $_SESSION['week'];
	$latest_7= strtotime("+7 days", $latest_t);
	$in_7= strtotime("+7 days", $today_str);
	if($thisWeek=='getweek1'){
		$offer_dates=array();	
		if ($latest_7<$in_7){
			$y=$latest_7;
			while ($y<$in_7){
				$offer_dates[]= $y;
		        $y=strtotime("+1 days", $y);
			}
			
		}
		
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
	if ($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1'){
	echo "<div class='table-responsive'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Steps</th><th>Collection Method</th></tr></thead>";
	}
	else {
		echo "<div class='table-responsive'> <table class='table'><thead><tr><th>Day</th><th>Date</th><th>Add walk?</th><th>Steps</th><th>Collection Method</th><th>Achieved target</th></tr></thead>";
	}
	// this looks for today's date, but maybe change for week view? -
	// if target not set makes sense to look at previous seven days but once target set, that should be "start date"
	// ? give option to move start date so Monday?
	$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

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
	else{
		if ($_SESSION['weekno'] % 2 == 1){

			$days_since =FLOOR(($today_str- $latest_t)/(60*60*24));
		    $startday =  strtotime("+". $days_since ." days", $latest_t);	
			$end= $days_since;
			// Don't display the mean number of steps
			$display=0;
		
		} else {
			//If it is the second week, show 7 days from the target
			$startday =  strtotime( "+13 days", $latest_t);			
			$days_since= FLOOR(($today_str- strtotime( "+6 days", $latest_t))/(60*60*24));
			$end = 6;
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
	WHERE u.username = '". $username ."'
  			;";
		//	echo $querysteps;
		$resultsteps = mysqli_query($connection, $querysteps)
		or die("Can't get steps data" . mysql_error());


		$rowsteps = mysqli_fetch_array($resultsteps);
		//Give the day and date relevant
		echo "<tr><td>". date('l', $x) ."</td><td>";
		echo date('j-m-y', $x);
		echo "</td><td>";
		if (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==0){
			if (isset($rowsteps['add_walk'])){
				echo $rowsteps['add_walk'];
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
			echo $rowsteps['steps'];
			$totalsteps= $totalsteps+ $rowsteps['steps'];
			$totaldays= $totaldays+ 1;
		}
		else {
			$key = array_search($x, $mytable);
			echo "<form class = 'form-inline'> <div class='form-group'>
        <input type='integer' class='form-control' placeholder='Enter steps' id='steps". $key ."'> </div>";
			echo "</form>";
		}
		echo "</td><td>";
		if (isset($rowsteps['method'])){
			echo $rowsteps['method_name'];}
			else{
				echo $rowsteps['preference'];
			}
			echo "</td>";
		if (($thisWeek=='baseline'||$thisWeek=='getweek1'||$thisWeek=='delayweek1')==0){
				if (isset($_SESSION['steps'])&&(isset($_SESSION['steps'])< $rowsteps['steps'])){
					echo "<td><span class='gliphicon glyphicon-star'></span></td>";
				}
				echo "<td></td>";
			}
			echo "</tr>";
	}
	echo "</table></div>";
	if (($totaldays!=""||isset($_SESSION['steps'])) && $display==1) {
		$avgsteps= round($totalsteps/$totaldays);
		$avgsteps= ceil($avgsteps/50)*50;
		if ($_SESSION['steps']!= $avgsteps) {
			$avgsteps=$_SESSION['steps'];	}		

		echo "<p><b>Your average daily step count =". $avgsteps ."</b>. This number is your <b>baseline steps</b><br></p><br>";
		echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";}	
    else if ($thisWeek=='baseline' && $display==0) {
    	echo "<p>At the end of the week the average number of steps you walked will be shown here. That number will be your <b>baseline steps</b><br></p><br>";
    	echo "<p>You will use this number to work out your target in the 12 week programme. In weeks 1-4 you will add 1500 steps to this number and gradually increase the number of days that you do this on. In weeks 5-12 you will add 3000 to this number and again gradually increase the number of days that you do this on.</p>";	    	
      }
//		mysqli_free_result($result);
	mysqli_close($connection);
}

?>