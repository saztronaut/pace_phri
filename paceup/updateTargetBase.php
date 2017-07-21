<?php

require 'database.php';
require 'updateTargetBaseFunctions.php';

if ($_POST){
	$numt = htmlspecialchars($_SESSION['numt'], ENT_QUOTES);
	$numt= preg_replace("/[^0-9]+/", "", $numt);
	$username = htmlspecialchars($_SESSION['username']);
	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$latest_t = htmlspecialchars($_SESSION['latest_t']);
	$latest_t= preg_replace("/[^0-9/-]+/", "", $latest_t);
	$steps = htmlspecialchars($_SESSION['steps']);
	updateTarget($numt, $username, $latest_t, $steps);
	
}

?>