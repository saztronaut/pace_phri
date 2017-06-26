<?php
include 'returnWeekFunctions.php';

if (isset($_POST['username'])){
	//if not post, then sessions already declared
	require 'sessions.php';
	
	
	if (isset($_SESSION['username'])=== false){
		echo 0;
	} else {
		if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
			$username = htmlspecialchars($_SESSION['ape_user']);
		}
		else {
		$username = htmlspecialchars($_SESSION['username']);
    }
	if ($username!==''){
	   $myweek=returnWeek($username);
	   if (isset($_POST['refresh'])){
		   $myweek=returnWeek($username);
	   }
	    echo json_encode($myweek);
	}
	}
	
}

?>