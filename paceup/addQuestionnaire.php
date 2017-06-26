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
			$value="'".htmlspecialchars($value)."'";
		}
		
		$fieldlist.=htmlspecialchars($key);
		$valuelist.=htmlspecialchars($value);
	}
	
	if (isset($_SESSION['username'])){
		$username=htmlspecialchars($_SESSION['username']);
		$addq= "INSERT INTO questionnaire (username, ".$fieldlist .") VALUES ('".$username."',". $valuelist .");";
		mysqli_query($connection, $addq);
		echo $addq;
		
	} else if(isset($_SESSION['get_username'])){
		$username=htmlspecialchars($_SESSION['get_username']);
		$addq= "INSERT INTO questionnaire (username, ".$fieldlist .") VALUES ('".$username."',". $valuelist .");";
		mysqli_query($connection, $addq);
		echo $addq;
	}
	
}

?>