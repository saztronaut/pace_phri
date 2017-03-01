<?php

if ($_POST){
	$pracID= htmlspecialchars($_POST['practice']);
} else {$pracID="";}
    require 'database.php';
	require 'sessions.php';	

  if ($pracID!=""){$lookup = "SELECT username FROM users WHERE pracID='".$pracID."';";}
  else{
  $lookup = "SELECT username FROM users;";}
  $result = mysqli_query($connection, $lookup) 
    or die("Hmm, that didn't seem to work" . mysql_error());
  if ($result){
	echo "<select name='user' id='chooseuser' class='form-control'>";
	echo "<option value='' disabled selected> Select the user</option>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option value='". $row['username'] ."'> ". $row['username'] ." </option> ";}		
		
		
	echo "</select>";}
	else { echo $lookup;}


//	exit;
?>