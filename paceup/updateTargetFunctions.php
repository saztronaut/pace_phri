<?php

//manually updated targets are for participants who do not hit the previous target but want to continue
if (function_exists('manualUpdateTarget')=== false){
	function manualUpdateTarget($username, $date_set){
		require 'database.php';
		include 'calcTarget.php';
		$row=getLatestTarget($username);
		$n_t = $row['n_t'];
		$getsteps= $row['steps'];
		// calcTarget will generate the information for the next target
		$mytarget=calcTarget($n_t, $getsteps);
		$days= $mytarget['days'];
		$steptarget=$mytarget['steptarget'];
		// send the target through
		$msg = insertTarget($username, $date_set, $steptarget, $days);
		return $msg;
	}
}

if (function_exists('checkTarget')=== false) {
	function checkTarget($username, $date_set){
		require 'database.php';
		$checkTargetQ= "SELECT * FROM targets WHERE date_set='". $date_set ."' AND username='".$username."';";
		$result = mysqli_query($connection, $checkTargetQ);
		if ($result->num_rows>0){
			return 1;
		} else {
			return 0;
		}
		mysqli_free_results($result);
	}
}

if (function_exists('updateTargetQ')=== false){
	function updateTargetQ($username, $date_set, $steptarget, $days){
		require 'database.php';
		$update_target = "UPDATE targets SET steps= '". $steptarget ."', days= '". $days ."' WHERE username='". $username ."' AND date_set='". $date_set ."';";
		if(mysqli_query($connection, $update_target) or die (0)){
		    return 1;
		} else {return 0;}
	}
}

if (function_exists('insertTarget')=== false){
	function insertTarget($username, $date_set, $steptarget, $days){
		require 'database.php';
		$insert_target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
		if (mysqli_query($connection, $insert_target) or die (0)){
		    return 1;
		} else {return 0;}
	}
}

if (function_exists('getLatestTarget')=== false){
	function getLatestTarget($username){
		require 'database.php';
		//how many targets has this user had, what was the latest target, how many steps was it, and on how many days
		$get_week= "SELECT n_t, latest_t, steps, days
			    FROM targets as t,
               (SELECT COUNT(*) as n_t, MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set) as a
                WHERE a.latest_t=t.date_set AND t.username='". $username ."';";
		
		// n_t gives the number of targets that are in the targets table
		// latest_t gives the date set of the most recent target
		// steps give the steps at the most recent target
		// days is the number of days the target was for
		$result = mysqli_query($connection, $get_week)
		or die("Can't find user week" . mysql_error());
		$row = mysqli_fetch_array($result);
		return $row;
		mysqli_free_results($result);
	}
}
?>