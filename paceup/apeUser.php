<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

require 'checkUserRights.php';
//Create PHP Session cookie to view steps pages as if user
//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES);
    $username= preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$ape_user = htmlspecialchars($_POST['username'], ENT_QUOTES);
	$ape_user= preg_replace("/[^a-zA-Z0-9]+/", "", $ape_user);
	// whichdata tells you what to download
	
	//check user has authority
	$auth= checkRights('R');

	if ($auth==1){
        $_SESSION['ape_user'] = $ape_user;
        $_SESSION['roleID'] = $row['roleID'];
        echo "You can now view the steps pages as " . $ape_user;
	}
		
	else {
		echo "You do not have the access privileges to look at other users";
	}
    
	mysqli_free_result($result);
	mysqli_close($connection);
    exit();
} else {
		echo "You do not have the access privileges to look at other users";
}
	
	
?>

