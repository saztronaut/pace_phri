<?php

  $lookup = "SELECT pracID, practice_name FROM practices;";
  $result = mysqli_query($connection, $lookup) 
    or die("Hmm, that didn't seem to work" . mysql_error());
	echo "<select name='practice' id='practice' class='form-control' >";
	echo "<option value='' disabled selected> Select your GP practice</option>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<option value='". $row['pracID'] ."'> ". $row['practice_name'] ." </option> ";		
		}		
		
	echo "</select>";
	
	mysqli_free_result($result);
?>