<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$errors = [];
if($_POST)
{
	$fieldlist="";
	$valuelist="";
	$first= 1;
	foreach($_POST as $key => $value) {
		if ($first==0){ 
			$fieldlist.=',';
			$valuelist.=',';
		}
		else {$first=0;}
		if (is_string($value)){
			// single quotes are a bit of a pain
			$value = str_replace("'", "", $value);
			$value="'".filter_var($value, FILTER_SANITIZE_STRING)."'";
		}
		
		$fieldlist.=htmlspecialchars($key);
		$valuelist.=filter_var($value, FILTER_VALIDATE_INT);
	}
	
	if (isset($_SESSION['username'])){
		$username=htmlspecialchars($_SESSION['username']);
		$addq= "INSERT INTO questionnaire (username, ".$fieldlist .") VALUES ('".$username."',". $valuelist .");";
		if (mysqli_query($connection, $addq)){
			echo 1;
		} else {
		    echo 0;
		}
		
	} else if(isset($_SESSION['get_username'])){
		$username=htmlspecialchars($_SESSION['get_username']);
		$addq= "INSERT INTO questionnaire (username, ".$fieldlist .") VALUES ('".$username."',". $valuelist .");";
		if (mysqli_query($connection, $addq)){
			echo 1;
			unset($_SESSION["get_username"]);
		} else {
			echo 0;
		}
	}
	
}

?>