<?php
	require 'database.php';
	require 'sessions.php';
	include 'get_json_encode.php';
    $results=[];
    //Takes the session['username'] as parameter
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
	$username = htmlspecialchars($_SESSION['username']);
	if (isset($username) && $username!=''){
	
	//Create any missing baseline targets	
	//subquery getValues queries the readings table against itsself, where r gives the date of the beginning of the epoch and m gives the steps in that epoch
	//getValues looks for the readings within 7 days
	//getDays uses the output of getValues and counts up how many have step counts, the average step count and gives the start (baseline) date
	//from this - the number of step counts must be >2 and the current date must be more than 6 days after the baseline and the user must already not have a baseline target
	
	
	$baseline_target = "INSERT INTO targets (username, date_set, steps, days)
                      SELECT getDays.username, getDays.start, getDays.base_steps, 0
                      FROM 
			          (SELECT COUNT(steps) as n, (CEIL(AVG(steps)/50)*50) as base_steps, getValues.date_read as start, username
                      FROM (SELECT r.date_read, m.steps, r.username
                      FROM readings as r,
                      readings as m
                      WHERE r.date_read<= m.date_read AND DATEDIFF(m.date_read, r.date_read)<7 AND DATEDIFF(m.date_read, r.date_read)>=0 AND r.username= m.username) as getValues
                      GROUP BY getValues.date_read, getValues.username) as getDays
                      WHERE getDays.n>2 AND DATEDIFF(CURDATE(), getDays.start)>=6 AND DATEDIFF(CURDATE(), getDays.start)<=35 AND getDays.username NOT IN
                      (SELECT username FROM targets) AND getDays.username='". $username ."' 
			          GROUP BY getDays.username
                      ORDER BY getDays.start LIMIT 1;";

	$getbase= mysqli_query($connection, $baseline_target);
	$results['week']='baseline';
	$today = date('Y-m-d');
	$today_str = strtotime($today);


	$get_week= "SELECT n_t, latest_t, steps, days 
			    FROM targets as t, 
               (SELECT COUNT(*) as n_t, MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set) as a 
                WHERE a.latest_t=t.date_set AND t.username='". $username ."';";

	$result = mysqli_query($connection, $get_week)
	      or die(0);
	$row = mysqli_fetch_array($result);

	if ($result->num_rows==0){
		$results['week']='baseline';
		$w=0;
	}
	else {
		$latest_t=strtotime($row['latest_t']);
		$getbase="SELECT steps  
			    FROM targets as t
                WHERE days='0' AND t.username='". $username ."';";
		$baselinesteps= mysqli_query($connection, $getbase)
		or die(0);
		$basesteps=mysqli_fetch_array($baselinesteps);
		$mybaseline=$basesteps['steps'];	
		if ($row['n_t']==1){
			$results['week']='getweek1';
			$w=1;
			// if the baseline was more than 5 weeks ago and they have not set a target, delete baseline from the database
			if (strtotime("+35 days", $latest_t)< $today_str){
				//delete the target
				$delete_target= "DELETE FROM targets WHERE username='".$username."';";
				 mysqli_query($connection, $delete_target) or die(0);
				 $results['refresh']='yes';
				 
			}
			
		}
		elseif ($row['n_t']>1 && $row['n_t']<8 ){
			$w=((($row['n_t'])-2)*2)+1;
			//if the target is in the future, you know that the participant has chosen when to increase but it is not yet (week 1 only)
			if ($latest_t> $today_str){
				$results['week']='delayweek'.$w;
			}
			// if the target was set less than a week ago, you are in 1st week of target
			elseif (strtotime('+7 days', $latest_t)>$today_str){
				$results['week']="week".$w;}
				// if the target was set less than a week ago, you are in 2nd week of target
				else {
					$w=$w+1;
					$results['week']="week".$w;
					// if the target was set more than 2 weeks ago, you need a new target
					if ((strtotime('+14 days', $latest_t)<$today_str)){
						$n=$row['n_t'];
				    updateTarget($n, $username, $latest_t, $row['steps']);	
					}
				}}
		else { $results['week']="week13";}
		
		$results['steps']=$row['steps'];
		$results['days']=$row['days'];
		$results['latest_t']=$row['latest_t'];
		$results['weekno']=$w;
		if (isset($mybaseline)) 
		{$results['baseline']=$mybaseline;} 
		else {$results['baseline'] = $row['steps'];}

	}
	//so now session contains a value for week which is:
	//baseline - show baseline week information,
	//getweek1 - introduce steps and show week 1. Give option to delay/ alter week1 start
	//delayweek - will show baseline steps view, will show baseline steps as static value, will say "you will increase your steps on X"
	//weekX - odds - will show target, will compare steps with target, will inform of baseline steps, will give other information
	//weekX - evens - will show target, will compare target with steps, if the p not reaching target then offer deferrment of level up
	//week13 - patients who have completed the course...
    $_SESSION['week']=$w;
	}
    
	if(!empty($results)) {
		// feedback results 
		$result_array = $results;
		echo json_encode($result_array);}
		else {echo 0;
		}
		
function updateTarget($numt, $username, $latest_t, $steps)
		{
			require 'database.php';
	//		require 'sessions.php';
			include 'get_json_encode.php';
			
			// n_t gives the number of targets that are in the targets table
			// latest_t gives the date set of the most recent target
			// steps give the steps at the most recent target
			// days is the number of days the target was for
			$getsteps= $steps;
			if ($numt==1||$numt==3){
				$days=3;
				$steptarget=$getsteps+1500;
			}
			elseif ($numt==2||$numt==4){
				$days=5;
				$steptarget=$getsteps;
			}
			elseif ($numt>5){
				$days=6;
				$steptarget=$getsteps;
			}
			
			// If it is the end of an even week, the participant should achieve their steps goal on a certain number of days. If they achieve it, they go up to the next week
			// If they do not achieve it, they do not. 
			// calculate how many days have passed since the latest tar
			$endEvenWeek = "SELECT COUNT(*) as achieved, days, DATE_ADD(date_set, INTERVAL 14 DAY) as date14
					FROM readings as r,
					(SELECT username, steps as target, date_set, days  FROM targets WHERE username='". $username ."' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set DESC)) as t
					WHERE r.username=t.username AND r.date_read between DATE_ADD(date_set, INTERVAL 6 DAY) AND DATE_ADD(date_set, INTERVAL 13 DAY) AND r.steps>=t.target;";
			$getEndWeek= mysqli_query($connection, $endEvenWeek);
			$row2 = mysqli_fetch_array($getEndWeek);
			$achieved = $row2['achieved'];
			$goal = $row2['days'];
		if (($achieved>=$goal) && isset($achieved)){
				$date_set = $row2['date14'];
				$target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
				$gettarget = mysqli_query($connection, $target);
				$results['refresh']="yes";
				}
		else {
			//how many weeks have there been since the target was set
			$today_str = strtotime(date('Y-m-d'));
			$weeksSinceT=FLOOR(($today_str-$latest_t)/(60*60*24*7));
			if ($weeksSinceT>2){
				//If there has been more than 2 week lapse since the last target
				//find out if the participant achieved their target in each week, beginning with the earliest
			for ($x = 3; $x <=$weeksSinceT; $x++) {
			//Allow automatic update to next level 
			//Interval should be 7 X number of weeks
			$int_days= $x*7;
			$endEvenWeek = "SELECT COUNT(*) as achieved, days, DATE_ADD(date_set, INTERVAL ". $int_days ." DAY) as date14
					FROM readings as r,
					(SELECT username, steps as target, date_set, days  FROM targets WHERE username='". $username ."' AND date_set=(SELECT MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set DESC)) as t
					WHERE r.username=t.username AND r.date_read between DATE_ADD(date_set, INTERVAL ". $int_days-7 ." DAY) AND DATE_ADD(date_set, INTERVAL ". $int_days-1 ." DAY);";
			$getEndWeek= mysqli_query($connection, $endEvenWeek);
			$row2 = mysqli_fetch_array($getEndWeek);
			$achieved = $row2['achieved'];
			$goal = $row2['days'];
			if (($achieved>=$goal) && isset($achieved)){
				$date_set = $row2['date14'];
				$target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
				$gettarget = mysqli_query($connection, $target);
				$results['refresh']="yes";
			      }
			      }
			}
		}
		}
