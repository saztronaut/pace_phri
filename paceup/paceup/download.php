<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'createDownload.php';




//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$data = htmlspecialchars($_POST['whichdata']);

	// whichdata tells you what to download
	
	//check user has authority to generate codes R= researcher S= superuser
	$checkauth= "SELECT roleID from users WHERE username='". $username ."';";
	$result= mysqli_query($connection, $checkauth) or die(0);
	$row = mysqli_fetch_array($result);
	
	if ($row['roleID']=="R" ||$row['roleID']=="S"){
         $query="";
		//Find out what to download
		switch ($data){
			case 'Users' : $query = "SELECT username, email, pracID, start_date, pref_method, other_method, roleID, referenceID FROM users;";
			break;
			case 'Steps' : $query = "SELECT * FROM steps;";
			break;
			case 'Practices' : $query = "SELECT * FROM practices;";
			break;
			case 'Targets' : $query = "SELECT * FROM targets;";
			break;
			case 'Methods' : $query = "SELECT * FROM methods;"; 
			break;
			case 'Reference' : $query = "SELECT * FROM reference;";
			break;
		}
		if ($query!=''){
		$result= mysqli_query($connection, $query) or die ("Can't fetch download" . mysql_error());
		$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
		array_to_csv_download($row, $data.date('d-m-y').".csv");
		echo "Your download should begin shortly";}
	    else{echo "Please make a selection from the list";}}
		else {echo "You do not have the access privileges to download data";}}
	else {
		echo "You do not have the access privileges to download data";
	}
	
	

?>

