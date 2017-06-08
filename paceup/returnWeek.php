<?php

if (isset($_POST['username'])){
	//if not post, then sessions already declared
	require 'sessions.php';
	
	
	if (isset($_SESSION['username'])=== false){
		echo 0;
	} else {
		if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
			$username = htmlspecialchars($_SESSION['ape_user']);
		}
		else {
		$username = htmlspecialchars($_SESSION['username']);
    }
	if ($username!==''){
	   $myweek=returnWeek($username);
	   if (isset($_POST['refresh'])){
		   $myweek=returnWeek($username);
	   }
	    echo json_encode($myweek);
	}
	}
	
}

if (function_exists('returnWeek')=== false){
function returnWeek($username){
	require 'database.php';
	require 'updateTargetAuto.php';
	require 'setBaseline.php';
	
	$results=[];
	$results['week']='baseline';
	$today = date('Y-m-d');
	$today_str = strtotime($today);
	// Query the database for the number of targets for this user
	$result= numTargets($username);
	$row = mysqli_fetch_array($result);
	
	if ($result->num_rows=== 0){
		// check for baseline steps
		// setBase($username);
		// requery to check baseline
		// $result= numTargets($username);
		$results['week']='baseline';
		$w=0;
	}
	if ($result->num_rows!== 0){
		
		$latest_t=strtotime($row['latest_t']);
		$getbase="SELECT steps
			    FROM targets as t
                WHERE days='0' AND t.username='". $username ."';";
		$baselinesteps= mysqli_query($connection, $getbase)
		or die(0);
		$basesteps=mysqli_fetch_array($baselinesteps);
		$mybaseline=$basesteps['steps'];
		mysqli_free_result($baselinesteps);
		$results['mybaseline']=$mybaseline;
		
		if ((int)$row['n_t']=== 1){
			$results['week']='getweek1';
			$w=1;
			// if the baseline was more than 5 weeks ago and they have not set a target, delete baseline from the database
			if (strtotime("+35 days", $latest_t)< $today_str){
				//delete the target
				$delete_target= "DELETE FROM targets WHERE username='".$username."';";
				mysqli_query($connection, $delete_target) or die(0);
				setBase($username);
				$result= numTargets($username);
				// if there is a more recent target available to replace the deleted one then you want to run this function again
				if ($result->num_rows==0){
					$results['week']='baseline';
					$w=0;
				} else {
					$results['week']='getweek1';
					$w=1;
					$getbase="SELECT steps
			    FROM targets as t
                WHERE days='0' AND t.username='". $username ."';";
					$baselinesteps= mysqli_query($connection, $getbase)
					or die(0);
					$basesteps=mysqli_fetch_array($baselinesteps);
					$mybaseline=$basesteps['steps'];
					mysqli_free_result($baselinesteps);
					$results['mybaseline']=$mybaseline;
				}
				
			}
			
		}
		elseif ($row['n_t']>1) {
			$w=((($row['n_t'])-2)*2)+1;	
			// If there has been longer than 14 days since last target, should have new one. Check eligible for new target
			if ((strtotime('+14 days', $latest_t)<= $today_str) && $w<13) {
				$refresh = updateTarget($username);
				if ($refresh === 1) {
					$result= numTargets($username);	
					$row=mysqli_fetch_array($result);
					$latest_t=strtotime($row['latest_t']);
					$w=((($row['n_t'])-2)*2)+1;	
				}
			}

			//if the target is in the future, you know that the participant has chosen when to increase but it is not yet (week 1 only)
			if ($w<13){
			   if ($latest_t> $today_str){
				  $results['week']='delayweek'.$w;
			   }
			   // if the target was set less than a week ago, you are in 1st week of target
			   elseif (strtotime('+7 days', $latest_t)>$today_str){
				  $results['week']="week".$w;
			   }
				  // if the target was set less than a week ago, you are in 2nd week of target
				  else {
					 $w=$w+1;
					 $results['week']="week".$w;
					// if the target was set more than 2 weeks ago, you need a new target
					 if ((strtotime('+14 days', $latest_t)<=$today_str) && $w<13){
						 $n=$row['n_t'];

					  }
				  }
			 } else if ($w>=13) {
					// if it is post week 12 but the user has decided not to carry on you don't want to do all this - revert to week 12
					
					
					//now need to calculate how many weeks since week 12 finished
					$order= 7;
					$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
					$get_steps_date = mysqli_query($connection, $get_date)
					or die("Can't get steps data" . mysql_error());
					$date_pick = mysqli_fetch_array($get_steps_date);
					// week 13 starts on $get_steps_date['date_set']
					$today_str = strtotime(date('Y-m-d'));
					$latest_t = strtotime($date_pick['date_set']);
					$weeksSince13=FLOOR(($today_str-$latest_t)/(60*60*24*7));
					//get the beginning of this week
					$thisStart= date("Y-m-d", ($latest_t + ($weeksSince13* 60*60*24*7)));
					$results['days']= $date_pick['days'];
					$results['steps']= $date_pick['steps'];
					$results['start']= $thisStart;
					$results['week']="week". (13 + $weeksSince13);
					$w=(13 + $weeksSince13);
					mysqli_free_results($get_steps_date);
				}
		}

	$results['row']=$row;
	$results['latest_t']=date("Y-m-d",$latest_t);				
	}
	$results['weekno']=$w;
	$_SESSION['week']=$w;
	
	return $results;
}


function numTargets($username){
	require 'database.php';
	$get_week= "SELECT n_t, latest_t, steps, days
			    FROM targets as t,
               (SELECT COUNT(*) as n_t, MAX(date_set) as latest_t FROM targets WHERE username='". $username ."' ORDER BY date_set) as a
                WHERE a.latest_t=t.date_set AND t.username='". $username ."';";
	
	$result = mysqli_query($connection, $get_week)
	or die(0);
	
	return $result;
	mysqli_free_result($result);
	
}

}
?>