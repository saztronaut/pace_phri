<?php
require 'database.php';
require 'sessions.php';


//check user has authority to generate codes R= researcher S= superuser

//using form data, generate so many codes and report them to the browser

if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$practice = htmlspecialchars($_POST['practice']);
	$pracID = htmlspecialchars($_POST['pracID']);

	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);

	if ($row['roleID']=="R" ||$row['roleID']=="S"){

		
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
	else {echo "You do not have the access privileges to generate registration codes";}
}
	else {
		echo "You do not have the access privileges to generate registration codes";
	}

	?>