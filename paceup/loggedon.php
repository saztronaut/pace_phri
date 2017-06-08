<?php
require 'database.php';
require 'sessions.php';
	
	if (isset($_SESSION['username'])){
	  $username = htmlspecialchars($_SESSION['username']);
	  $role = htmlspecialchars($_SESSION['roleID']);
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


