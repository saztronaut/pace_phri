<?php

require 'database.php';
require 'sessions.php';
$myStepsprint=[];
$myTargetsprint=[];
$myTargetsarray=[];
$myfirstTarget=[];
$counter=0;
$username='bruce';
$today = date('Y-m-d');
$show_days = 90;
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
			echo "<p>". $getdate ."</p>";
			echo "<p>". strtotime($getdate) ."</p>";
			echo "<p>". strtotime($only_show) ."</p>";
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
				if (strtotime($getdate) >= strtotime($only_show)){
					$myTargetsprint[]=array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
				}
			}
			else {
				if ($x <= 6){
					$thisweek = ($x*2)-1;
					$week = 12;
				}
				else {
					$week = $week + 1;
					$thisweek = $week;
				}
				if (strtotime($getdate) >= strtotime($only_show)){
					echo "<p> print target</p>";
					$myTargetsprint[] = array('week'=> $thisweek, 'date_set'=> $getdate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
				}
				// find out the date of the next target
				
				$diff = floor(abs(strtotime($getdate) - strtotime($enddate))/(60*60*24));
				
				$nweeks = CEIL((($diff)-1)/7);
				
				// round it up to the nearest multiple of 7
				if ($nweeks>1){
					$subweek=0; //subweek when there are more than one week within a
					// add a new row in to $myTargetsprint
					for ($i=1; $i<$nweeks; $i++) {
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
						if (strtotime($newDate) >= strtotime($only_show)){
							$myTargetsprint[] = array('week'=> $thisweek,'date_set'=> $newDate, 'steps' => $target_row['steps'], 'days' => $target_row['days']);
						}
						$subweek = $subweek+1;
					}
				}
			}
		}
}
$mydate = date_format(date_create("2017-04-05"), 'Y-m-d');
$mydate2 = "2017-06-05";
echo "<p>Date format:" . $mydate . "</p>";
echo "<p>Plain date:" . $mydate2 . "</p>";

// select a time period to show from
$only_show = date_format(date_add(date_create($today), date_interval_create_from_date_string("-" . $show_days . " days")), 'Y-m-d');

echo "<p>Date format:" .$only_show. "</p>";
echo "<p>Only show :" .strtotime($only_show). "</p>";
echo "<p>My date:" .strtotime($mydate). "</p>";
echo "<p>My date2:" .strtotime($mydate2). "</p>";
if  (strtotime($mydate2)>=strtotime($only_show)) {
	echo "true";
}
	else {
		echo "false";
}

?>