<?php
include 'updateTargetAutoFunctions.php';
if (isset($_POST['numt'])==1){
	require 'sessions.php';
	
	$numt= htmlspecialchars($_POST['numt']);
   	$numt= preg_replace("/[^0-9]+/", "", $numt);
	$username = htmlspecialchars($_SESSION['username']);
   	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);	
	updateTarget($username);
	
}

?>