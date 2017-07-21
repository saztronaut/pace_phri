<?php
require 'database.php';
require 'sessions.php';
	
	if (isset($_SESSION['username'])){
	  $username = htmlspecialchars($_SESSION['username']);
      $username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	  $role = htmlspecialchars($_SESSION['roleID']);
	  $role = preg_replace("/[^RSU]+/", "", $role);
	  $results=[];
	  $results['role']=$role;
	  $results['username']=$username;
	  if (isset($_SESSION['ape_user'])) {
	  	$results['ape_user'] = $_SESSION['ape_user'];
	  } else {
	  	$results['ape_user'] = "";
	  }
	echo json_encode($results);
	} 
	else { echo 0;}


?>


