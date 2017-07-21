<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';

$getUser = [];
if ($_POST){
	//	$registration=htmlspecialchars($_POST['reg']);
	$username = htmlspecialchars($_POST['username']);	
   	$username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$input = htmlspecialchars($_POST['input']);	
   	$input= preg_replace("/[^a-zA-Z0-9]+/", "", $input);
	$control = htmlspecialchars($_POST['control'], ENT_QUOTES);	
   	$control= preg_replace("/[^a-zA-Z]+/", "", $control);
	$auth = checkRights('R');
	if ($auth==1){
		if ($control=="gender" || $control=="ethnicity"){
   	        $input= preg_replace("/[^ABFMOW]+/", "", $input);		    
			$updateUser= "UPDATE reference SET " . $control . "= '". $input ."' WHERE referenceID IN (SELECT referenceID FROM users WHERE username='". $username ."');";
		} else if ($control=="age") {
   	        $input= preg_replace("/[^0-9]+/", "", $input);		    
			$updateUser= "UPDATE reference SET " . $control . "=". $input ." WHERE referenceID IN (SELECT referenceID FROM users WHERE username='". $username ."');";		
		} else {
		    $input= preg_replace("/[^0-1]+/", "", $input);
			$updateUser= "UPDATE users SET " . $control . "= '". $input ."' WHERE username='". $username ."';";
		}
			if (mysqli_query($connection, $updateUser)){
				echo 1;
			//	echo $updateUser;
			} else {
			    echo 0;
		    	//echo $updateUser;
			}
		}
	} else {
	echo 2;
	}


?>