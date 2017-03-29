<?php
require 'database.php';
require 'sessions.php';
	
	if (isset($_SESSION['username'])){
	  $username = htmlspecialchars($_SESSION['username']);
	  $role = htmlspecialchars($_SESSION['roleID']);
	  $results=[];
	  $results['role']=$role;
	  $results['username']=$username;
	echo json_encode($results);
	} 
	else { echo 0;}


?>


