<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';


//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
	$data = htmlspecialchars($_POST['whichdata']);
    $data = preg_replace("/[^a-zA-Z0-9]+/", "", $data);
	// whichdata tells you what to download
	
	//check user has authority to generate codes R= researcher S= superuser
	$auth = checkRights('R');
	$condition="";
	
	if ($_POST['narrowby']=="User"){
	    $getUser =  htmlspecialchars($_POST['User']);
	    $getUser = preg_replace("/[^a-zA-Z0-9]+/", "", $getUser);
		$condition=" WHERE username='". $getUser ."' ";
	}
	if ($_POST['narrowby']=="Practice") {
	    $getPractice=  htmlspecialchars($_POST['Practice']);
	    $getPractice= preg_replace("/[^a-zA-Z0-9]+/", "", $getPractice);	    
		if ($data=="Users"){
		$condition="WHERE pracID='". $getPractice ."'";}
		else if ($data=="Steps"){
		$condition=", users WHERE readings.username=users.username AND users.pracID='". $getPractice ."'";
		}
		else if ($data=="Targets"){
			$condition=", users WHERE targets.username=users.username AND pracID='". $getPractice ."'";
		}
	}
	
	
	if ($auth==1){
         $query="";
		//Find out what to download
		switch ($data){
			case 'Users' : $query = "SELECT username, forename, lastname, email, pracID, start_date, pref_method, other_method, roleID, referenceID FROM users ".$condition.";";
			break;
			case 'Steps' : $query = "SELECT readings.username, forename, lastname, steps, date_read, date_entered, add_walk, method FROM readings ".$condition.";";
			break;
			case 'Practices' : $query = "SELECT * FROM practices;";
			break;
			case 'Targets' : $query = "SELECT targets.username, date_set, steps, days FROM targets ".$condition.";";
			break;
			case 'Methods' : $query = "SELECT * FROM methods;"; 
			break;
			case 'Reference' : $query = "SELECT * FROM reference;";
			break;
			case 'Questionnaire' : $query = "SELECT * FROM questionnaire;";
			break;
			case 'Emails' : $query = "SELECT username, purpose_name, time_sent, email FROM emails, email_purpose WHERE emails.purpose=email_purpose.purpose;";
			break;
		}
		if ($query!=''){
			//echo $query;
		$result= mysqli_query($connection, $query) or die ("Error retrieving data" . mysql_error());
		$row = mysqli_fetch_all($result, MYSQLI_ASSOC);	
		echo '{"data":'.json_encode($row).'}';
		mysqli_free_result($result);
		mysqli_close($connection);
         exit();
		}
	    else {echo "Please make a selection from the list";}}
		else {echo "You do not have the access privileges to download data";}}
	else {
		echo "You do not have the access privileges to download data";
	}
	
	
?>

