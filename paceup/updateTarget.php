<?php
include 'updateTargetFunctions.php';

 if (isset($_POST['date_set'])=== true) {
    require 'sessions.php';
   $date_set=date("Y-m-d",strtotime($_POST['date_set']));
   $username = htmlspecialchars($_SESSION['username']);
   if (isset($_POST['post12'])==1){
   	$steptarget=$_POST['steptarget'];
   	$days=$_POST['days'];
   	if (checkTarget($username, $date_set)==0){
   	if (insertTarget($username, $date_set, $steptarget, $days)){
   		echo "target updated";
   	}
   }
   else{
   	if (updateTargetQ($username, $date_set, $steptarget, $days)){
   		echo "target updated";
   	}
   }
   }
   else{
    manualUpdateTarget($username, $date_set);}
 }


?>
