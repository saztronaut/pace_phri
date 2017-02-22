<?php
require 'database.php';
require 'sessions.php';
$results=[];


$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$weekno= $_POST['weekno']; //This tells you what stage the pt is at on the pathway
// For odd weeks, get the target set and then display values for 7 days afterwards
if ($weekno % 2 == 1 || $weekno==0){
	$order= CEIL($weekno/2);
	$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
	$get_steps_date = mysqli_query($connection, $get_date)
	or die("Can't get steps data" . mysql_error());
	$date_pick = mysqli_fetch_array($get_steps_date);
	
	$get_end_date = "SELECT DATE_ADD(date_set, INTERVAL 6 DAY) as date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .",1;";
	$row_end_date = mysqli_query($connection, $get_end_date)
	or die("Can't get steps data" . mysql_error());
	$end_date_pick = mysqli_fetch_array($row_end_date);
}
// For even weeks, get 7 days after the target was set and then display up until the target changes. 
// As the draw table function will automatically shift the 7 days, just return the target
else{
	$order= $weekno/2;
	$get_date = "SELECT date_set, days, steps FROM targets WHERE username='". $username ."' ORDER BY date_set LIMIT ". $order .", 1;";
	$get_steps_date = mysqli_query($connection, $get_date)
	or die("Can't get steps data" . mysql_error());
	$date_pick = mysqli_fetch_array($get_steps_date);
	
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
   $results['weekno']=$weekno;
   $results['baseline'] = $date_pick['steps'];

if(!empty($results)) {
	$result_array = $results;
	echo json_encode($result_array);}
	else {echo 0;}


?>