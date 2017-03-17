<?php

    require 'database.php';
	require 'sessions.php';	

  
  $lookup = "SELECT pracID, practice_name FROM practices;";
  $result = mysqli_query($connection, $lookup) 
    or die("Could not get practices" . mysql_error());
  if ($result){
	echo "<select name='practice' id='choosePractice' class='form-control'>";
	echo "<option value='' disabled selected> Select the practice</option>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option value='". $row['pracID'] ."'> ". $row['practice_name'] ." </option> ";}		
				
		
	echo "</select>";}
	else {echo $lookup;}

//	mysqli_free_result($result);
//	exit;
?>