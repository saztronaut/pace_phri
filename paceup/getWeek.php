<?php
	require 'database.php';
	require 'sessions.php';
	include 'get_json_encode.php';
	include 'returnWeek.php';
	$results=[];
    //Takes the session['username'] as parameter
	//Query the database to find out where the participant is in terms of targets and weeks.
	//If no target, the participant is at baseline
	//If has baseline "target" - i.e. baseline measurement alone, then they have not been properly introduced to week 1 so they need
	//to see the text about how the targets are increasing and how this is week 1  

	//Participants can delay the start of week one to let them have a logical week i.e. start on Monday so this may also happen
	//Particpants who have finished baseline should not be able to change the baseline values
	//If p has baseline & week 1 targets then they are on either week 1 or week 2 or week 2+ and this can be ascertained by
	//Looking at the time difference between the target setting and the curdate.
	//And so on for the remaining weeks
	// If there is no baseline target, add if needed
	if (isset($_SESSION['username'])){
	$username = htmlspecialchars($_SESSION['username']);
	if (isset($_POST['viewWeek'])){ $weekno=$_POST['viewWeek'];} else {$weekno="";}; //if the user is viewing a week in the past, take this week as argument instead of the current week
	if (isset($username) && $username!=''){
	
		$results= returnWeek($username);
		if (isset($results['refresh'])){
			// rerun function
			$results= returnWeek($username);
		}
		$w= $results['weekno'];
		$week = $results['week'];
		if ( $w>0 ){
		$row = $results['row'];	
		$results['steps']=$row['steps'];
		$results['days']=$row['days'];
		$results['latest_t']=$row['latest_t'];
		$today= date('Y-m-d');
		$latest_t=date('Y-m-d', strtotime($results['latest_t']));
		}
		if ($w>13){
			$showSumm= "SELECT finish_show FROM users WHERE username='".$username."' ;";
			$summResult= mysqli_query($connection, $showSumm) or die("Error checking if summary or no");
			$getSum= mysqli_fetch_array($summResult);
			$summary=$getSum['finish_show'];
			if ($summary==0){
				//update finish_show to 1 so that the summary will be shown
				$updateSumm= "UPDATE users SET finish_show=1 WHERE username='". $username ."';";
				mysqli_query($connection, $updateSumm) or die($updateSumm.mysql_error());
				$summary=1;
			}
			$results['summary']= $summary;
			if ($latest_t>$today){
				// get previous// current target
				$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set DESC LIMIT 1, 1;";
				$myresults= mysqli_query($connection, $get_date);
				$row=mysqli_fetch_array($myresults);
				$results['steps']=$row['steps'];
				$results['days']=$row['days'];
				$results['latest_t']=$row['date_set'];
				$weeksSince13=FLOOR((strtotime($today)-strtotime($results['latest_t']))/(60*60*24*7));
				//get the beginning of this week
				$thisStart= date("Y-m-d", (strtotime($results['latest_t'])+ ($weeksSince13* 60*60*24*7)));
				$results['start']= $thisStart;
				
			}
			
		}

		//get any comments from that week. recorded on weeks 2, 3, 4, 5, 6, 8, 10, 12
		//get comment data
		if ($weekno!='' && (is_null($weekno)==0) && $weekno!="null"){
			$results=pastWeek($weekno, $username);
			//get comment from the past week
		$commentq = "SELECT text FROM notes WHERE username='".$username."' AND week=".$weekno.";";
		$resultcomment=mysqli_query($connection, $commentq) or die(0);
		if ($resultcomment->num_rows>0){
			$rowcomment= mysqli_fetch_array($resultcomment);
			$comment=$rowcomment['text'];}
			else{$comment="";}					
		} else {

		$results['weekno']=$w;	

			$commentq = "SELECT text FROM notes WHERE username='".$username."' AND week=".$w.";";
			$resultcomment=mysqli_query($connection, $commentq) or die(0);
			if ($resultcomment->num_rows>0){
				$rowcomment= mysqli_fetch_array($resultcomment);
				$comment=$rowcomment['text'];}
				else{$comment="";}
		}
		
		
			
		
		if (isset($results['mybaseline'])) 
		{$results['baseline']=$results['mybaseline'];} 
		//else {$results['baseline'] = $row['steps'];}
		$results['comment']=$comment;
		$results['maxweekno']=$w;

	}
	//so now session contains a value for week which is:
	//baseline - show baseline week information,
	//getweek1 - introduce steps and show week 1. Give option to delay/ alter week1 start
	//delayweek - will show baseline steps view, will show baseline steps as static value, will say "you will increase your steps on X"
	//weekX - odds - will show target, will compare steps with target, will inform of baseline steps, will give other information
	//weekX - evens - will show target, will compare target with steps, if the p not reaching target then offer deferrment of level up
	//week13 - patients who have completed the course...

    
	if(!empty($results)) {
		// feedback results 
		$result_array = $results;
		echo json_encode($result_array);}
		else {echo 0;
		}
		
	}
	else {
		echo 0;
	}
	
	
function pastWeek($weekno, $username){
	require 'database.php';
	//require 'sessions.php';
	// For odd weeks, get the target set and then display values for 7 days afterwards
	$results=[];
	if ($weekno<13){
	if ($weekno % 2 == 1 || $weekno==0){
		$order= CEIL($weekno/2);
		//$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
		//$get_steps_date = mysqli_query($connection, $get_date)
		//or die("Can't get steps data" . mysql_error());
		//$date_pick = mysqli_fetch_array($get_steps_date);
	
		$date_pick=getPastWeek($username, $order);
		$get_end_date = "SELECT DATE_ADD(date_set, INTERVAL 6 DAY) as date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
		$row_end_date = mysqli_query($connection, $get_end_date)
		or die("Can't get steps data" . mysql_error());
		$end_date_pick = mysqli_fetch_array($row_end_date);
	}
	// For even weeks, get 7 days after the target was set and then display up until the target changes.
	// As the draw table function will automatically shift the 7 days, just return the target
	else{
		$order= $weekno/2;
		//$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .", 1;";
		//$get_steps_date = mysqli_query($connection, $get_date)
		//or die("Can't get steps data" . mysql_error());
		//$date_pick = mysqli_fetch_array($get_steps_date);
		$date_pick=getPastWeek($username, $order);
		
		$next= $order + 1;
		$get_end_date = "SELECT DATE_SUB(date_set, INTERVAL 1 DAY) as date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $next .",1;";
		$row_end_date = mysqli_query($connection, $get_end_date)
		or die("Can't get steps data" . mysql_error());
		$end_date_pick = mysqli_fetch_array($row_end_date);
	}
	    $start_date= $date_pick['date_set'];
	    $results['steps']=$date_pick['steps'];
	    $results['days']=$date_pick['days'];
	    $results['latest_t']=$date_pick['date_set'];
	    $results['finish']=$end_date_pick['date_set'];
	    $results['week']="week". $weekno;
	}
	else {
		$date_pick= getPastWeek($username, 7);
		
		//Date today
		$today_str = strtotime(date('Y-m-d'));
		//How long ago was the "13 week target" set
		$latest_t = strtotime($date_pick['date_set']);
		//how many weeks since that target was set
		$weeksSince13= $weekno-13;
		//get the beginning of this week
		$thisStart= date("Y-m-d", ($latest_t + ($weeksSince13* 60*60*24*7)));
		$results['start']= $thisStart;
		$results['week']="week". $weekno;
		$w=$weekno;
		$end_date_pick = 0; //This should just show a 7 day epoch or however many days this week
		$results['steps']=$date_pick['steps'];
		$results['days']=$date_pick['days'];
		$results['latest_t']=date("Y-m-d", $latest_t);
		$results['finish']=date('Y-m-d',strtotime('+7 days', strtotime($thisStart)));
		$results['maxweekno']=$w;
	}

	$results['weekno']=$weekno;
	return $results;
	
}
		
function getPastWeek($username, $order){
	require 'database.php';
	$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
	$get_steps_date = mysqli_query($connection, $get_date)
	or die("Can't get steps data" . mysql_error());
	$date_pick = mysqli_fetch_array($get_steps_date);
	return $date_pick;
}


