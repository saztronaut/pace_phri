<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';


//check user has authority to generate codes R= researcher S= superuser
//using form data, generate so many codes and report them to the browser
$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$n_codes = htmlspecialchars($_POST['n_codes']);
	$practice = htmlspecialchars($_POST['practice']);

	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$auth= checkRights('R');

	if ($auth==1){
		$edituser= htmlspecialchars($_POST['chooseuser']);
		$role=htmlspecialchars($_POST['role']);
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
