<?php
include 'updateTargetFunctions.php';
// Update a target for a user using POST. 

if (isset($_POST['date_set'])=== true) {
    require 'sessions.php';
    
   	$date_set=date("Y-m-d",strtotime($_POST['date_set']));
   	if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
   		$username = htmlspecialchars($_SESSION['ape_user']);
   	}
   	else if (isset($_SESSION['username'])){
   		$username = htmlspecialchars($_SESSION['username']);
   	}
   	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
   	if (isset($_POST['post12'])==1){
   		// If user is post12 then targets are defined by the user
   		$steptarget=htmlspecialchars($_POST['steptarget'], ENT_QUOTES);
   	    $steptarget= preg_replace("/[^0-9]+/", "", $steptarget);   		
   		$days=htmlspecialchars($_POST['days'], ENT_QUOTES);
   	    $days= preg_replace("/[^0-9]+/", "", $days);      		
   		if (checkTarget($username, $date_set)==0){
   			// If there is already a target set, then the existing record needs to be replaced
   			if (insertTarget($username, $date_set, $steptarget, $days)){
   			echo "target updated";
   		}
   	} else	{ // Otherwise a record needs to be added to the targets table
   		if (updateTargetQ($username, $date_set, $steptarget, $days)){
   			echo "target updated";
   		}
   	}
} else {
	// If not POST then this means this is called by bump target which means go to the next target for this individual, using date_set as a base
    manualUpdateTarget($username, $date_set);}
}


?>
