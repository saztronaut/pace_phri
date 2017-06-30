<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

$getUser = [];
if ($_POST){
	//	$registration=htmlspecialchars($_POST['reg']);
	$username = htmlspecialchars($_POST['username']);	
	$input = htmlspecialchars($_POST['input']);	
	$control = htmlspecialchars($_POST['control']);	
	$auth = checkRights('R');
	if ($auth==1){
		if ($control=="gender" || $control=="ethnicity"){
			$updateUser= "UPDATE reference SET " . $control . "= '". $input ."' WHERE referenceID IN (SELECT referenceID FROM users WHERE username='". $username ."');";
		} else if ($control=="age") {
			$updateUser= "UPDATE reference SET " . $control . "=". $input ." WHERE referenceID IN (SELECT referenceID FROM users WHERE username='". $username ."');";		
		} else {
			$updateUser= "UPDATE users SET " . $control . "= '". $input ."' WHERE username='". $username ."';";
		}
			if (mysqli_query($connection, $updateUser)){
				echo 1;
			} else {
		    	echo $updateUser;
			}
		}
	} else {
	echo 2;
	}


?>