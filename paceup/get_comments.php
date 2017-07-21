<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$myComments=[];
if (isset($_SESSION['username'])){
	$username = htmlspecialchars($_SESSION['username']);
$username = preg_replace("/[^a-zA-Z0-9]+/", "", $username);
//show all the steps over time


for ($x = 0; $x <13; $x++) {
	//see if there are any comments
	$getCommentq= "SELECT text FROM notes WHERE username='".$username."' AND week=".$x.";";
	$results = mysqli_query($connection, $getCommentq)
	or die("Can't get steps data" . mysql_error());
	$row= mysqli_fetch_array ($results);
	$myComments[$x]= $row['text'];

	mysqli_free_result($results);
}
}
//out put the group to the page
if(!empty($myComments)) {
	// feedback results
	echo json_encode($myComments);}
	else {echo 0;}

	
	
?>
