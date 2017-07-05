<?php
require 'database.php';

if (function_exists('setBase')==0){
	function setBase($username){
		require 'database.php';
		//Create any missing baseline targets
		//subquery getValues queries the readings table against itsself, where r gives the date of the beginning of the epoch and m gives the steps in that epoch
		//getValues looks for the readings within 7 days
		//getDays uses the output of getValues and counts up how many have step counts, the average step count and gives the start (baseline) date
		//from this - the number of step counts must be >2 and the current date must be more than 6 days after the baseline and the user must already not have a baseline target
		$hasbaseq= "SELECT * FROM targets WHERE username='". $username ."';";
		$hasbase= mysqli_query($connection, $hasbaseq) or die("Error checking targets");
		if ($hasbase->num_rows>=1){
			return 2;
		} else {
			$comparator=">"; // if there is a value entered today, then can calculate baseline, otherwise hold off calculating baseline- otherwise baseline could be calculated prematurely
			$readingtoday= "SELECT * FROM readings WHERE username='". $username ."' AND date_read=CURDATE();";
			$checkreading= mysqli_query($connection, $readingtoday) or die("Error checking today's reading");
			if ($checkreading->num_rows==1) {
				$comparator=">=";
			}
		
			$baseline_target = "INSERT INTO targets (username, date_set, steps, days)
                      SELECT getDays.username, getDays.start, getDays.base_steps, 0
                      FROM
			          (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
                      FROM (SELECT r.date_read, m.steps, r.username
                      FROM readings as r,
                      readings as m
                      WHERE r.date_read<= m.date_read AND DATEDIFF(m.date_read, r.date_read)<7 AND DATEDIFF(m.date_read, r.date_read)>=0 AND r.username= m.username) as getValues
                      GROUP BY getValues.date_read, getValues.username) as getDays
                      WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)".$comparator."6 AND DATEDIFF(CURDATE(), getDays.start)<=35 AND getDays.username NOT IN
                      (SELECT username FROM targets) AND getDays.username='". $username ."'
			          GROUP BY getDays.username
                      ORDER BY getDays.start LIMIT 1;";
			if ($getbase = mysqli_query($connection, $baseline_target)==1){
				$hasbase = mysqli_query($connection, $hasbaseq) or die("Error checking targets");
				if ($hasbase-> num_rows>=1){
					return 1;
				} else {
				return 0;
			}
			mysqli_free_result($getbase);
		mysqli_free_result($hasbase);
	}
}
}
}
?>