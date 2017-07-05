<?php
include 'updateTargetAutoFunctions.php';
if (isset($_POST['numt'])==1){
	require 'sessions.php';
	
	$numt= htmlspecialchars($_POST['numt']);
	$username = htmlspecialchars($_SESSION['username']);
	
	updateTarget($username);
	
}

?>