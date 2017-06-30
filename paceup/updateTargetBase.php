<?php

require 'database.php';
require 'updateTargetBaseFunctions.php';

if ($_POST){
	$numt = htmlspecialchars($_SESSION['numt']);
	$username = htmlspecialchars($_SESSION['username']);
	$latest_t = htmlspecialchars($_SESSION['latest_t']);
	$steps = htmlspecialchars($_SESSION['steps']);
	updateTarget($numt, $username, $latest_t, $steps);
	
}

?>