<?php

require 'database.php';
require 'sessions.php';

if ($_POST){
	$registration=htmlspecialchars($_POST['reg']);
	//$date_rem=htmlspecialchars($_POST['date_rem']);
	if (htmlspecialchars($_POST['e_consent'])==true){$e_consent=1;} else {$e_consent=0;} 
	if (htmlspecialchars($_POST['e_consent_a'])==true){$e_consent_a=1;} else {$e_consent_a=0;}
	if (htmlspecialchars($_POST['e_consent_v'])==true){$e_consent_v=1;} else {$e_consent_v=0;}
	if (htmlspecialchars($_POST['e_consent_gp'])==true){$e_consent_gp=1;} else {$e_consent_gp=0;}
	if (htmlspecialchars($_POST['e_consent_t'])==true){$e_consent_t=1;} else {$e_consent_t=0;}
	$gender=htmlspecialchars($_POST['gender']);
	$ethnicity=htmlspecialchars($_POST['ethnicity']);
	$age=htmlspecialchars($_POST['age']);
	$username = htmlspecialchars($_SESSION['username']);

	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);

	if ($row['roleID']=="S"||$row['roleID']=="R"){
		
		$lookup = "UPDATE reference SET e_consent=".$e_consent.", e_consent_v=".$e_consent_v.", e_consent_a=".$e_consent_a.", e_consent_gp=".$e_consent_gp.", 
				e_consent_t=".$e_consent_t.", gender='".$gender."', ethnicity='".$ethnicity."', age=".$age." WHERE referenceID='".$registration."';";
		$ref=mysqli_query($connection, $lookup) or die($lookup);
		if ($ref){
			echo 'Update successful';}

			else {echo "Oops, something went wrong";}
	}
	else {echo "You do not have sufficient access privileges to view this data";}


}

?>