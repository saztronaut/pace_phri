<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';


//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$ape_user = htmlspecialchars($_POST['username']);
	// whichdata tells you what to download
	
	//check user has authority to generate codes R= researcher S= superuser
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);

	if ($row['roleID']=="R" ||$row['roleID']=="S"){
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

