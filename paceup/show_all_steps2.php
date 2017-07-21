<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

//show_all_steps.php provides feedback on steps progress. The final output is $myStepsprint, $myTargetsprint, $myfirstTarget, number of days shown (default 90)
// This follows the following steps
// 1. initialise and set up vars
// 2. obtain the information on the number of targets recorded
// 3. iterate through the targets and get a record for each week to show
// 4. iterate through the days of each week and extract the steps data to record
// 5. output the results

$myStepsprint=[]; // date of steps, walk y/n, steps walked, device used, date of target, target, days to hit target
$myTargetsprint=[]; // gives a record for each week. week number, date beginning of week, steps goal, days to hit target, total steps walked, total days recorded
$myTargetsarray=[]; // This is the output from querying the targets table, used to create myTargetsprint
$myfirstTarget=[]; // First target set - used to inform a select so that users can view further back

$counter=0; // counts through the weeks

if (isset($_SESSION['username'])) {
	$username = htmlspecialchars($_SESSION['username']);
}

if (isset($_SESSION['ape_user'])){  //if an admin is viewing as a user
	$auth= checkRights('R');	
	if ((int)$auth===1){
	$username = htmlspecialchars($_SESSION['ape_user']);
	}
}
 
if (isset($username)){
$username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	
// how many days of data to show. default: 90
if (isset($_POST['show_days'])){
	$show_days = $_POST['show_days'];
	$show_days = preg_replace("/[^0-9]+/", "", $show_days);
} else {
	$show_days = 91;
}

	
//show all the steps over time

//first target date should be the beginning date
//today would be the last date
$today = date('Y-m-d');

// check to see if the user has opted to finish the programme and only show them from their last recorded step
$checkFinishq = "SELECT finish_show FROM users WHERE username='". $username ."';";
$checkFinish = mysqli_query($connection, $checkFinishq) or die ("can't check summary".mysql_error());
$finishArray= mysqli_fetch_array($checkFinish);
if ((int)$finishArray['finish_show'] === 3){ // the user decided to stop recording steps
	$getLatestReadingq = "SELECT MAX(date_read) as recent FROM readings WHERE username='". $username ."';";
	$getLatestReading= mysqli_query($connection, $getLatestReadingq) or die ("can't get latest reading".mysql_error());
	$latestReading= mysqli_fetch_array($getLatestReading);
	$today = date('Y-m-d', strtotime($latestReading['recent'])); // replace the value for "today" with the last step recorded. 
}
		
// select a time period to show from 
$only_show = date_format(date_add(date_create($today), date_interval_create_from_date_string("-" . $show_days . " days")), 'Y-m-d'); 
// get all targets from targets table
$getTargetsq= "SELECT date_set, steps, days FROM targets WHERE username='". $username ."' AND date_set<=CURDATE() ORDER BY date_set;";
$getTargets= mysqli_query($connection, $getTargetsq) or die("Can't find user's targets" . mysql_error());

if ($getTargets->num_rows === 0){
	// user only has baseline set
	$getFirstReadQ = "SELECT MIN(date_read) AS earliest FROM readings WHERE username='". $username ."';";
	$getFirstRead =  mysqli_query($connection, $getFirstReadQ);
	$row = mysqli_fetch_array($getFirstRead);
	$getdate = $row['earliest'];	
	$myTargetsprint[]=array('week'=> 0, 'date_set'=> $getdate, 'steps' => 0, 'days' => 0);
} else {

	// feed each target into a row in $myTargetsarray

while ($target_row = mysqli_fetch_array($getTargets, MYSQLI_ASSOC)){
	if ($counter==0){
		$initaldate=$target_row['date_set'];
	}
    $myTargetsarray[]= $target_row;}
    
    mysqli_free_result($getTargets);
    //For each target, work out the distance between them in weeks and fill in the gaps so for each chronological week you have a target, date and label
    //This means if there is a 3 week gap between two targets, you will have a row for each week in the gap, corresponding to the earlier target. 
    //now many targets are there
    $n_targets=count($myTargetsarray)-1;
// Start with the first target 

    for ($x=0; $x<=($n_targets); $x++){
    	$target_row = $myTargetsarray[$x];  		
    	$getdate = $target_row['date_set'];
    	if ($x == $n_targets){
    		$enddate= $today; // if this is the last target, then end on today's date
    	}
    		else{
    			$nexttar = $myTargetsarray[$x+1]; // if not the last target, end on the next target
    			$enddate = $nexttar['date_set'];
    		}
    		if ($x == 0){// baseline week
    	$thisweek = 0;
    	$myfirstTarget['target'] = $getdate;
    	if (strtotime($getdate) >= strtotime($only_show)){
     			$myTargetsprint[]=array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    		}
    	}
    	else { 
    		if ($x <= 6){// during 12 weeks programme - week numbers have specific relevance i.e. to increases and diary
    	$thisweek = ($x*2)-1; // only odd weeks have their own target record. They always last 1 week
    		$week = 12;
    		}
    	else { // post 12 weeks programme - week numbers do not have specific relevance
    		$week = $week + 1;
    		$thisweek = $week;
    	}
    	if (strtotime($getdate) >= strtotime($only_show)){ // add to array if within time frame
    		$myTargetsprint[] = array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    }
    	// how many days are there between this target and the next?

    		$diff = floor(abs(strtotime($getdate) - strtotime($enddate))/(60*60*24));
    		// how many weeks is that?
    		$nweeks = CEIL((($diff)-1)/7);
    		
    	if ($nweeks>1){
    		$subweek=0; //subweek when there are more than one week within a target epoch. This is a counter
    			// add a new row in to $myTargetsprint
    		for ($i=1; $i<$nweeks; $i++) {
    			if ($x > 6) { //if post 12, then show each week separately
    				$week = $week + 1;
    				$thisweek = $week;
    			} else { //if the first round on that week, then show number only, otherwise indicate attempt number
    			   if ($subweek == 0) { 
    				   $thisweek = $x*2; // even weeks can be longer than 1 week if required multiple attempts to hit target
    			   } else { 
    				$thisweek = ($x*2)." Attempt #".($i);
    			   }
    			}		   
    			$newDate = date('Y-m-d', strtotime("+".($i*7) ." days", strtotime($getdate))); // add number of weeks to target
    			if (strtotime($newDate) >= strtotime($only_show)){ // add to array if within time frame
    				$myTargetsprint[] = array('week'=> $thisweek,'date_set'=> $newDate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    			}
    			$subweek = $subweek+1; // increase subweek for events when there are multiple attempts to repeat a week. 12 week programme only
    		    }
    		}
    	}
    }
}
// iterate through myTargetsprint to get the step counts for each week
    $all_weeks=count($myTargetsprint)-1;
    
    for ($i=0; $i<=($all_weeks); $i++){
    	$target_row=$myTargetsprint[$i];   	
    	$getdate = $target_row['date_set'];
          if ((int)$i === $all_weeks){
               $enddate = $today; // if the most recent week, take today as last date
          }
          else{
    	        $nexttar=$myTargetsprint[$i+1]; // otherwise take the next date in myTargetsprint
    	        $enddate=date('Y-m-d', strtotime("-1 days", strtotime($nexttar['date_set'])));
               }
           // get the date of the newest record. 
         // get the difference between that date and date_set
        $gap=date_diff(date_create($getdate),date_create($enddate));
        // convert that gap to days
        $ndays=$gap->d;
        $mySteps=[]; // store steps for the given week in here
        $stepcount=0; // count number of days altogether in the array - this needs to equal $n_days ^^
        $totalsteps=0; // total steps walked
        $totaldays=0; // count number of days you have steps recorded
        $getStepsq="SELECT ".$counter.", date_read AS date, add_walk, steps as steps, method_name as method, '". $getdate. "' as date_set, ". $target_row['steps']. " as target, ". $target_row['days']." as days 
              FROM readings, methods WHERE methods.methodID=readings.method AND date_read BETWEEN '".$getdate."' AND'". $enddate."' AND username='". $username."'";
        $getSteps=mysqli_query($connection, $getStepsq) or die("Can't find user's steps" . mysql_error());    

       while ($step_row = mysqli_fetch_array($getSteps, MYSQLI_ASSOC)){
    	    //if the date_read is higher than the date indicated by step count, then you need to add a new row with no steps values
    	    while (date('Y-m-d', strtotime("+". $stepcount ." days", strtotime($getdate)))< $step_row['date']){
    		    $mySteps[] = array($counter => $counter, 'date' => date('Y-m-d', strtotime("+". $stepcount ." days", strtotime($getdate))));
    		    $stepcount= $stepcount+1; // add to the days in the array
    	    }
    	// if you have a steps value for a given date then record that
    	    $mySteps[]=$step_row; 
    	    $totalsteps=$totalsteps+$step_row['steps']; // add to the steps total
    	    $totaldays=$totaldays+1; // add to the number of days you have recorded
    	    $stepcount= $stepcount+1; // add to the days in the array
        }
    
        while ($stepcount<=$ndays){ //if there are missing days at the end of a week, add them until you have enough
    	$mySteps[]=array($counter => $counter, 'date' => date('Y-m-d',strtotime("+". $stepcount ." days", strtotime($getdate))));
    	$stepcount= $stepcount+1;
    }
    $myTargetsprint[$i]['totalsteps']=$totalsteps; // add the totals to the "myTargetsprint array, which contains weekly info
    $myTargetsprint[$i]['totaldays']=$totaldays;
    
    mysqli_free_result($getSteps);
    
    $myStepsprint[$counter]= $mySteps;	
    $counter=$counter+1;
    }
}


//out put the group to the page
if(!empty($myStepsprint)&&!empty($myTargetsprint)) {
	// feedback results
	$step_array = $myStepsprint;
	$result_array = $myTargetsprint;
	echo '{"targets":'.json_encode($result_array). ',"steps":'. json_encode($step_array).',"initial":'. json_encode($myfirstTarget).', "show_days": '. $show_days .', "end_date": "'. $only_show .'"}';
} else {
	echo 0;
}

mysqli_close($connection);	
exit;
?>
