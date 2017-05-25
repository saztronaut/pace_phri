<?php
require 'database.php';
require 'sessions.php';

if (isset($_SESSION['username'])){
$username = htmlspecialchars($_SESSION['username']);
$minRole=$_POST['min_account'];

// practice tells you which practice the codes are for
// n codes tells you how many codes to generate
$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
$result= mysqli_query($connection, $checkauth) or die(0);
$row = mysqli_fetch_array($result);

switch ($minRole){
	case 'U' : if ($row['roleID']=="S"||$row['roleID']=="R"||$row['roleID']=="U")
	{ echo 1;} else {echo 0;};
	break;
	case 'R' : if ($row['roleID']=="S"||$row['roleID']=="R")
	{ echo 1;} else {echo 0;};
	break;
	case 'S' : if ($row['roleID']=="S")
	{ echo 1;} else {echo 0;};
	break;
}
}
else {echo 0;}
exit
?>
