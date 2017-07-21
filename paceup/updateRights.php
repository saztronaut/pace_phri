<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

//check user has authority to change the priveleges (Superuser)
//Update user rights
$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);
	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$auth= checkRights('S');

	if ($auth==1){
		$edituser= htmlspecialchars($_POST['user']);
		$edituser= preg_replace("/[^a-zA-Z0-9]+/", "", $edituser);
		$role=htmlspecialchars($_POST['role']);
		$role= preg_replace("/[^RSU]+/", "", $role);		
		if ($edituser!="" && $role!=""){
			$alteruser ="UPDATE users  SET roleID = '". $role ."' WHERE `users`.`username` = '".$edituser."';";
			$update = mysqli_query($connection, $alteruser) or die("Couldn't update user");
			if ($update){
				echo "User: ". $edituser . " updated to role ". $role; 
			}
			else { echo "Error updating user";}
		} else{
			echo "Please select a user and a new role";
		}		
		
	}
else{
	echo "You do not have the access privileges to change user rights";
}	
}
	
	?>
