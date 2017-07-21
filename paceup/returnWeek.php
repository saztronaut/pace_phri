<?php


include 'returnWeekFunctions.php';

if (isset($_POST['username'])){
	//if not post, then sessions already declared
	require 'sessions.php';
	
	
	if (isset($_SESSION['username'])=== false){
		echo 0;
	} else {
		if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
			$username = htmlspecialchars($_SESSION['ape_user'], ENT_QUOTES);
		}
		else {
		$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);
    }
	if ($username!==''){
   	   $username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);  
	   $myweek=returnWeek($username);
	   if (isset($_POST['refresh'])){
		   $myweek=returnWeek($username);
	   }
	    echo json_encode($myweek);
	}
	}
	
}

?>