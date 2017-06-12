<?php
require 'database.php';
require 'sessions.php';

$msg=0;
if (isset($_SESSION['ape_user']) && ($_SESSION['roleID']=='R'||$_SESSION['roleID']=='S')){
	$username = htmlspecialchars($_SESSION['ape_user']);
}
else if (isset($_SESSION['username'])){
	$username = htmlspecialchars($_SESSION['username']);
}

if (isset($username)){
    $lookup = "SELECT username FROM questionnaire WHERE username='" . $username . "';";
    $result = mysqli_query($connection, $lookup) or die(0);
    
    if ($result -> num_rows==0){
    	$msg = 1; //no questionnaire recorded so show questionnaire
    } else if ($result -> num_rows == 1) {
    	$msg = 2; //questionnaire recorded
    }

} else {
	$msg = 0;
}

echo $msg;

?>