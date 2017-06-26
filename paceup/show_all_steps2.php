<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

$myStepsprint=[];
$myTargetsprint=[];
$myTargetsarray=[];
$myfirstTarget=[];
$counter=0;
if (isset($_SESSION['username'])) {
	$username = htmlspecialchars($_SESSION['username']);
}

if (isset($_SESSION['ape_user'])){
	$auth= checkRights('R');	
	if ($auth==1){
	$username = htmlspecialchars($_SESSION['ape_user']);
	}
}
 
if (isset($username)){
	
// how many days of data to show. default: 90
if (isset($_POST['show_days'])){
	$show_days = $_POST['show_days'];
} else {
	$show_days = 90;
}

	
//show all the steps over time

//first target date should be the beginning date
//today would be the last date
$today = date('Y-m-d');
// select a time period to show from 
$only_show = date_format(date_add(date_create($today), date_interval_create_from_date_string("-" . $show_days . " days")), 'Y-m-d'); 

$getTargetsq= "SELECT date_set, steps, days FROM targets WHERE username='". $username ."' AND date_set<=CURDATE() ORDER BY date_set;";

$getTargets= mysqli_query($connection, $getTargetsq) or die("Can't find user's targets" . mysql_error());

if ($getTargets->num_rows === 0){
	$getFirstReadQ = "SELECT MIN(date_read) AS earliest FROM readings WHERE username='". $username ."';";
	$getFirstRead =  mysqli_query($connection, $getFirstReadQ);
	$row = mysqli_fetch_array($getFirstRead);
	$getdate = $row['earliest'];	
	$myTargetsprint[]=array('week'=> 0, 'date_set'=> $getdate, 'steps' => 0, 'days' => 0);
} else {

//For each target, output an array of the corresponding steps

//$nTargets=$getTargets->num_rows;

while ($target_row = mysqli_fetch_array($getTargets, MYSQLI_ASSOC)){
	if ($counter==0){
		$initaldate=$target_row['date_set'];
	}
    $myTargetsarray[]= $target_row;}
    
    mysqli_free_result($getTargets);
    
    //now many targets are there
    $n_targets=count($myTargetsarray)-1;
  //  echo "num targets=". $n_targets;
// Start with the first target 

    for ($x=0; $x<=($n_targets); $x++){
    	$target_row = $myTargetsarray[$x];  		
    	$getdate = $target_row['date_set'];
    	if ($x == $n_targets){
    		$enddate= $today; // if this is the last target, then end on today's date
    	}
    		else{
    			$nexttar = $myTargetsarray[$x+1];
    			$enddate = $nexttar['date_set'];
    		}
    	if ($x == 0){
    	$thisweek = 0;
    	$myfirstTarget['target'] = $getdate;
    		if ($getdate >= $only_show){
     			$myTargetsprint[]=array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    		}
    	}
    	else { 
    		if ($x<=6){
    	$thisweek = ($x*2)-1;
    		$week = 12;}
    	else {
    		$week = $week + 1;
    		$thisweek = $week;
    	}
    	if ($getdate >= $only_show){
    		$myTargetsprint[] = array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    	}
    	// find out the date of the next target

    	//$nexttar=$myTargetsarray[$x+1];
    	//$enddate=$nexttar['date_set'];
    //	$gap=date_diff(date_create($getdate), date_create($enddate));
    	
    //	if ($enddate == $today){
    		$diff = floor(abs(strtotime($getdate) - strtotime($enddate))/(60*60*24));
    		//$gap = date_diff(date_create($getdate), date_create($today));
    		$nweeks = CEIL((($diff)-1)/7);
    	///	echo " n_weeks: ". $nweeks;
    	///	echo " get_date: ". $getdate;
    	//	echo " today: ". $today;
    	//} else {
    //		$nweeks = (CEIL(($gap->d-1)/7));}
    		
    		// round it up to the nearest multiple of 7
    	if ($nweeks>1){
    		$subweek=0; //subweek when there are more than one week within a 
    			// add a new row in to $myTargetsprint
    		for ($i=1; $i<=$nweeks; $i++) {
    			if ($x > 6) { //if post 12, then show each week separately
    				$week = $week + 1;
    				$thisweek = $week;
    			} else { //if the first round on that week, then show number only, otherwise indicate attempt number
    			   if ($subweek == 0) { 
    				   $thisweek = $x*2;
    			   } else { 
    				$thisweek = ($x*2)." Attempt #".($i);
    			   }
    			}		   
    			$newDate = date('Y-m-d', strtotime("+".($i*7) ." days", strtotime($getdate)));
    			$myTargetsprint[] = array('week'=> $thisweek,'date_set'=> $newDate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
    			$subweek = $subweek+1;
    		    }
    		}
    	}
    }
}
    	//echo '{"targetsprint":'.json_encode($myTargetsprint). '}';
    $all_weeks=count($myTargetsprint)-1;
    
    for ($i=0; $i<=($all_weeks); $i++){
    	$target_row=$myTargetsprint[$i];   	
    	$getdate = $target_row['date_set'];
          if ((int)$i == $all_weeks){
               $enddate= $today;
            //   echo "today";
          }
          else{
    	        $nexttar=$myTargetsprint[$i+1];
    	        $enddate=date('Y-m-d', strtotime("-1 days", strtotime($nexttar['date_set'])));
               }
        //       echo "list ".$i;
         //      echo "end ".$enddate;
          //     echo "start ".$getdate;
               
           // get the date of the newest record. 
         // get the difference between that date and date_set
        $gap=date_diff(date_create($getdate),date_create($enddate));
        $ndays=$gap->d;
        $mySteps=[];
        $stepcount=0; 
        $totalsteps=0; 
        $totaldays=0;
        $getStepsq="SELECT ".$counter.", date_read AS date, add_walk, steps as steps, method_name as method, '". $getdate. "' as date_set, ". $target_row['steps']. " as target, ". $target_row['days']." as days 
              FROM readings, methods WHERE methods.methodID=readings.method AND date_read BETWEEN '".$getdate."' AND'". $enddate."' AND username='". $username."'";
    

        $getSteps=mysqli_query($connection, $getStepsq) or die("Can't find user's steps" . mysql_error());    

       while ($step_row= mysqli_fetch_array($getSteps, MYSQLI_ASSOC)){
    	    //if the date_read is higher than the date indicated by step count, then you need to add a new row
    	    while (date('Y-m-d', strtotime("+". $stepcount ." days", strtotime($getdate)))< $step_row['date']){
    		    $mySteps[]=array($counter => $counter, 'date' => date('Y-m-d', strtotime("+". $stepcount ." days", strtotime($getdate))));
    		    $stepcount= $stepcount+1;
    	    }
    	
    	    $mySteps[]=$step_row;
    	    $totalsteps=$totalsteps+$step_row['steps'];
    	    $totaldays=$totaldays+1;
    	    $stepcount= $stepcount+1;
        }
    
        while ($stepcount<=$ndays){
    	$mySteps[]=array($counter => $counter, 'date' => date('Y-m-d',strtotime("+". $stepcount ." days", strtotime($getdate))));
    	$stepcount= $stepcount+1;
    }
    $myTargetsprint[$i]['totalsteps']=$totalsteps;
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
