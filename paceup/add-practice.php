<?php
require 'database.php';
require 'sessions.php';

include 'checkUserRights.php';
//check user has authority to generate codes R= researcher S= superuser

//using form data, generate so many codes and report them to the browser

if ($_POST){

	$username = filter_var($_SESSION['username'], FILTER_SANITIZE_STRING);
	$practice = filter_var($_POST['practice'], FILTER_SANITIZE_STRING);
	$pracID = filter_var($_POST['pracID'], FILTER_SANITIZE_STRING);

	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$auth = checkRights('R');

	if ($auth==1){
	
			//Check that this sequence is unique
			$checkID="SELECT * FROM practices WHERE pracID='". $pracID . "' ;";
			$unique = mysqli_query($connection, $checkID) or die(0);
			$checkprac="SELECT * FROM practices WHERE practice_name='". $practice . "';";
			$uniquep = mysqli_query($connection, $checkprac) or die(0);
			$is_unique=1;
			if ($unique->num_rows>0){
			    echo "That practice ID is already in use";
			    $is_unique=0;
			}
			if ($uniquep->num_rows>0){
				echo "That practice name is already listed";
				$is_unique=0;
			}
			if ($is_unique==1){
				$add_reg="INSERT INTO practices (pracID, practice_name) VALUES (UPPER('". $pracID."'),'".$practice."');";
				mysqli_query($connection, $add_reg) or die(0);
				echo "Practice added to the database";
				//$results['response'].= $response;
			
		}

	}
	else {
		echo "You do not have the access privileges to generate registration codes";}
}
	else {
	echo "You do not have the access privileges to generate registration codes";
}

?>