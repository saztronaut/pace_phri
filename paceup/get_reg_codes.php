<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'createDownload.php';


//check user has authority to generate codes R= researcher S= superuser

//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$n_codes = htmlspecialchars($_POST['n_codes']);
	$practice = htmlspecialchars($_POST['practice']);

	// practice tells you which practice the codes are for
	// n codes tells you how many codes to generate
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);

	$reg_codes=[];
	$print_reg_codes=[];
	$print_reg_codes[0]=array('registration code', 'practice code', 'date issue');
	$results['response']= "";
	
	if ($row['roleID']=="R" ||$row['roleID']=="S"){

		for ($x = 0; $x <$n_codes; $x++) {
		$reg_codes[$x] =bin2hex(openssl_random_pseudo_bytes(5));
		//Check that this sequence is unique
		$checkunique="SELECT * FROM reference WHERE referenceID='". $reg_codes[$x] . "';";
		$unique = mysqli_query($connection, $checkunique) or die(0);
		if ($unique->num_rows>0){
			//not unique
		}else {
		$add_reg="INSERT INTO reference(referenceID, issue_date, practice, in_use, consent) VALUES ('". $reg_codes[$x]."',CURDATE(),'".$practice."', 0, 0);";
		mysqli_query($connection, $add_reg) or die(0);
		//print the registration code to the browser
		//echo "<p>". $reg_codes[$x]. " ". $practice . " ". date("d-m-y"). "</p>";
		$print_reg_codes[$x+1]= array($reg_codes[$x], $practice, date("d-m-y"));
		//$results['response'].= $response;
		}
		}

		//array_to_csv_download($print_reg_codes, "reg_code".date('d-m-y').".csv");
		echo '{"data":'. json_encode($print_reg_codes).'}';  }
		else {echo "You do not have the access privileges to generate registration codes";}}
	else {
		echo "You do not have the access privileges to generate registration codes";
	}
	
	

?>

