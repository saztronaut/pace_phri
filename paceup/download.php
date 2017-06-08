<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';
include 'checkUserRights.php';


//using form data, generate so many codes and report them to the browser
	$results=[];
if ($_POST){

	$username = htmlspecialchars($_SESSION['username']);
	$data = htmlspecialchars($_POST['whichdata']);

	// whichdata tells you what to download
	
	//check user has authority to generate codes R= researcher S= superuser
	$auth = checkRights('R');
	$condition="";
	
	if ($_POST['narrowby']=="User"){
		$condition=" WHERE username='". $_POST['User'] ."' ";
	}
	if ($_POST['narrowby']=="Practice") {
		if ($data=="Users"){
		$condition="WHERE pracID='".$_POST['Practice']."'";}
		else if ($data=="Steps"){
		$condition=", practices WHERE readings.username==practices.username AND pracID='".$_POST['Practice']."'";
		}
		else if ($data=="Targets"){
			$condition=", practices WHERE targets.username==practices.username AND pracID='".$_POST['Practice']."'";
		}
	}
	
	
	if ($auth==1){
         $query="";
		//Find out what to download
		switch ($data){
			case 'Users' : $query = "SELECT username, email, pracID, start_date, pref_method, other_method, roleID, referenceID FROM users ".$condition.";";
			break;
			case 'Steps' : $query = "SELECT * FROM readings ".$condition.";";
			break;
			case 'Practices' : $query = "SELECT * FROM practices;";
			break;
			case 'Targets' : $query = "SELECT * FROM targets ".$condition.";";
			break;
			case 'Methods' : $query = "SELECT * FROM methods;"; 
			break;
			case 'Reference' : $query = "SELECT * FROM reference;";
			break;
			case 'Questionnaire' : $query = "SELECT * FROM questionnaire;";
			break;
		}
		if ($query!=''){
			//echo $query;
		$result= mysqli_query($connection, $query) or die ("Can't fetch download" . mysql_error());
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

