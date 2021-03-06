<?php
if (function_exists('updateTarget')=== false){
	function updateTarget($username)
	{
		require 'database.php';
		include 'calcTarget.php';
		include 'updateTargetFunctions.php';
		
		$row=getLatestTarget($username);
		$numt = $row['n_t'];
		$steps= $row['steps'];
		$latest_t= strtotime($row['latest_t']);
		
		if ($numt > 2){
		// n_t gives the number of targets that are in the targets table
		// latest_t gives the date set of the most recent target
		// steps give the steps at the most recent target
		// days is the number of days the target was for
		$mytarget=calcTarget($numt, $steps);
		$days = $mytarget['days'];
		$steptarget = $mytarget['steptarget'];
		
		//how many weeks have there been since the target was set
		$today_str = strtotime(date('Y-m-d'));
		$weeksSinceT=FLOOR(($today_str-$latest_t)/(60*60*24*7));
		if ((int)$weeksSinceT>=2){
			//If there has been more than 2 week lapse since the last target
			//find out if the participant achieved their target in each week, beginning with the earliest
			for ($x = 2; $x <=$weeksSinceT; $x++) {
				//Allow automatic update to next level
				//Interval should be 7 X number of weeks
				$int_days= $x*7;
				$endEvenWeek = "SELECT COUNT(*) as achieved, days, DATE_ADD(date_set, INTERVAL ". $int_days ." DAY) as date14
					FROM readings as r,
					(SELECT username, steps as target, date_set, days  FROM targets WHERE username='". $username ."' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set DESC)) as t
					WHERE r.username=t.username AND r.date_read between DATE_ADD(date_set, INTERVAL ". ($int_days-7) ." DAY) AND DATE_ADD(date_set, INTERVAL ". ($int_days-1) ." DAY) AND r.steps>=". $steps .";";
				$getEndWeek= mysqli_query($connection, $endEvenWeek) or die("Can't check week" . mysql_error());
				$row2 = mysqli_fetch_array($getEndWeek);
				$achieved = $row2['achieved'];
				$goal = $row2['days'];
				if ($goal>5 && $numt<7){ 
					$goal = 5;
				} //"most days"
				if (($achieved>=$goal) && isset($achieved)) {
					$date_set = $row2['date14'];
					setTarget($username, $date_set, $steptarget, $days);
					//$target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
					//$gettarget = mysqli_query($connection, $target);
					$results['refresh']="yes";
					return 1;
				}//achieved target
				else if ((int)$x === (int)$weeksSinceT) {
					return 0;
				}
				mysqli_free_result($getEndWeek);
			}//loop through weeks
		}//more than 1 week lapsed
		mysqli_close($connection);
	}
	}
}
if (function_exists('setTarget') === false){
	function setTarget($username, $date_set, $steptarget, $days){
		require 'database.php';
		$target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
		$gettarget = mysqli_query($connection, $target) or die("Can't add target" . mysql_error());
		//mysqli_free_result($gettarget);
	}
}
?>