
<?php

 if (isset($_POST['date_set'])==1) {
 	//require 'database.php';
    require 'sessions.php';
    //include 'calcTarget.php';
   $date_set=$_POST['date_set'] ;
  // $weekno=$_POST['weekno'] ;

  $username = htmlspecialchars($_SESSION['username']);
 // $steps = htmlspecialchars($_SESSION['steps']);
  manualUpdateTarget($username, $date_set);
 }

 //manually updated targets are for participants who do not hit the previous target but want to continue
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
  $insert_target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
   $gettarget = mysqli_query($connection, $insert_target);
  }
  
 
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
 }
 
   
 // 	exit;



?>
