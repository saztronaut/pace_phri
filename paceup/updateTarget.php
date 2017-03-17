<!DOCTYPE html>
<html lang="en">
<?php
 	require 'database.php';
    require 'sessions.php';
    include 'calcTarget.php';
 if ($_POST) {
   $date_set=$_POST['date_set'] ;
   $weekno=$_POST['weekno'] ;

  $username = htmlspecialchars($_SESSION['username']);
  $steps = htmlspecialchars($_SESSION['steps']);


//get week 
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

  $n_t = $row['n_t'];
  $getsteps= $row['steps'];

  $mytarget=calcTarget($n_t, $getsteps);
  $days= $mytarget['days'];
  $steptarget=$mytarget['steptarget'];
     // send the target through
  $insert_target = "INSERT INTO targets (username, date_set, steps, days) VALUES ('". $username ."', '". $date_set ."', '". $steptarget ."','". $days ."');";
   $gettarget = mysqli_query($connection, $insert_target);
  }
   
 // 	exit;



?>
