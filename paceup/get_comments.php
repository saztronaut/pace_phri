<?php
require 'database.php';
require 'sessions.php';
include 'get_json_encode.php';

$myComments=[];
if ($_POST){
	$username = htmlspecialchars($_SESSION['username']);

//show all the steps over time


for ($x = 0; $x <13; $x++) {
	//see if there are any comments
	$getCommentq= "SELECT text FROM notes WHERE username='".$username."' AND week=".$x.";";
	$results = mysqli_query($connection, $getCommentq)
	or die("Can't get steps data" . mysql_error());
	$row= mysqli_fetch_array ($results);
	$myComments[$x]= $row['text'];

}
}
//out put the group to the page
if(!empty($myComments)) {
	// feedback results
	echo json_encode($myComments);}
	else {echo 0;}

?>
